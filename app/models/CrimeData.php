<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Models;

use Nette\Diagnostics\Debugger;


/**
 * Description of Sectors
 *
 * @author petr
 */
class CrimeData extends BaseModel {
    protected $table = 'CrimeData';
    protected $key = 'Id';
    
    public function insert($data)
    {
        return $this->db->insert($this->table,$data)->execute();
    }
    
    public function findAreaCrime($area,$crime,$yearFrom,$monthFrom,$yearTo,$monthTo)
    {
        return $this->db->query('
            SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv, Name as area FROM CrimeData 
            JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            WHERE FK_Area_Lookup=%i AND FK_Crime_Lookup =%i AND (CONCAT(Year,IF(Month < 10,0,""),Month) >=%i%i) AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=%i%i)',$area,$crime,$yearFrom,$monthFrom,$yearTo,$monthTo);
    }
    
    public function findAreaCrimes($area,$yearFrom,$monthFrom,$yearTo,$monthTo, $isDistrict )
    {
        if( $isDistrict == "false" ) {
            return $this->db->query('
            SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv, Name as area,FK_Crime_Lookup as crime,
            ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i
            FROM CrimeData 
            JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            WHERE FK_Area_Lookup=%i AND (CONCAT(Year,IF(Month < 10,0,""),Month) >=%i%i) AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=%i%i) GROUP BY FK_Crime_Lookup',$area,$yearFrom,$monthFrom,$yearTo,$monthTo);
            
            Debugger::log('findAreaCrimes 666'); 
        } else {
            $sql = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv, Name as area,FK_Crime_Lookup as crime,
            ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i
            FROM CrimeData 
            JOIN DistrictLookup ON FK_District_Lookup = DistrictLookup.Id 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            WHERE FK_District_Lookup='.$area.' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') GROUP BY FK_Crime_Lookup';
            
            Debugger::log('findAreaCrimes'); 
            Debugger::log( $sql ); 

            return $this->db->query( $sql );
        }
    }
    
    public function findNameCrimes($name,$yearFrom,$monthFrom,$yearTo,$monthTo,$filters)
    {
        return $this->db->query('
            SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv, Name as area,FK_Crime_Lookup as crime,
            ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i,
            AreaLookup.Id AS AreaId
            FROM CrimeData 
            JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            WHERE AreaLookup.Name=%s AND (CONCAT(Year,IF(Month < 10,0,""),Month) >=%i%i) AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=%i%i) GROUP BY FK_Crime_Lookup',$name,$yearFrom,$monthFrom,$yearTo,$monthTo);
    }
    
    public function findAreaTotal($area,$yearFrom,$monthFrom,$yearTo,$monthTo,$crimeTypes,$isDistrict)
    {
        if( $isDistrict == "false" ) {
            if( empty( $crimeTypes ) || $crimeTypes == "1,2,3,4,5,6,7,8,9" ) {
                $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv,ROUND((SELECT SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i
                FROM CrimeData 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                JOIN AreaLookup ON AreaLookup.Id = FK_Area_Lookup
                WHERE FK_Area_Lookup='.$area.' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') AND FK_Crime_Lookup NOT IN(10,11)';
            } else {
                $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv,ROUND(((SELECT SUM(Vykazovane_zjisteno_mesic)
                FROM CrimeData 
                JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE FK_Area_Lookup='.$area.' AND ( CONCAT(Year,IF(Month < 10,0,""),Month ) >='.$yearFrom.$monthFrom.' )AND ( CONCAT( YEAR, MONTH ) <='.$yearTo.$monthTo.' ) AND FK_Crime_Lookup IN ( ' . $crimeTypes . ' ) )/(Population))*10000,0) AS i
                FROM CrimeData 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                JOIN AreaLookup ON AreaLookup.Id = FK_Area_Lookup
                WHERE FK_Area_Lookup='.$area.' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') AND FK_Crime_Lookup NOT IN(10,11) AND FK_Crime_Lookup IN('.$crimeTypes.')';
            }
        } else {
            if( empty( $crimeTypes ) || $crimeTypes == "1,2,3,4,5,6,7,8,9" ) {
                $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv,ROUND((SELECT SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i
                FROM CrimeData 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                JOIN DistrictLookup ON DistrictLookup.Id = FK_District_Lookup
                WHERE FK_District_Lookup='.$area.' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') AND FK_Crime_Lookup NOT IN(10,11)';
            } else {
                $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv,ROUND(((SELECT SUM(Vykazovane_zjisteno_mesic)
                FROM CrimeData 
                JOIN DistrictLookup ON FK_District_Lookup = DistrictLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE FK_District_Lookup='.$area.' AND ( CONCAT(Year,IF(Month < 10,0,""),Month ) >='.$yearFrom.$monthFrom.' )AND ( CONCAT( YEAR, MONTH ) <='.$yearTo.$monthTo.' ) AND FK_Crime_Lookup IN ( ' . $crimeTypes . ' ) )/(Population))*10000,0) AS i
                FROM CrimeData 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                JOIN DistrictLookup ON DistrictLookup.Id = FK_District_Lookup
                WHERE FK_District_Lookup='.$area.' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') AND FK_Crime_Lookup NOT IN(10,11) AND FK_Crime_Lookup IN('.$crimeTypes.')';
            }
        }
        
        //Debugger::log('findAreaTotal'); 
        //Debugger::log( $query ); 

        return $this->db->query( $query );

    }
    
    public function findTimeline( $crimeTypes )
    {
        //check if need to select only certain crimeTypes
        if( empty( $crimeTypes ) || $crimeTypes == "1,2,3,4,5,6,7,8,9" ) {
            //can select all crime types ( except 10, 11 - don't apply to statistics)
            $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS abs, Month, Year FROM CrimeData
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE FK_Crime_Lookup NOT IN(10,11) AND FK_Area_Lookup=1
                GROUP BY FK_Time_Range';
        } else {
             //need to select only specified crimetypes
            $query = 'SELECT SUM(Vykazovane_zjisteno_mesic) AS abs, Month, Year FROM CrimeData
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE FK_Crime_Lookup IN( ' .$crimeTypes. ') AND FK_Area_Lookup=1
                GROUP BY FK_Time_Range';
        }

        //Debugger::log('findTimeline'); 
        //Debugger::log( $query );

        return $this->db->query( $query );
    }
    
    public function findIndexes( $firstId, $lastId, $yearFrom, $monthFrom, $yearTo, $monthTo, $isDistrict)
    {   
        if( !$isDistrict ) {
            $query = 'SELECT ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i,AreaLookup.Id AS area, Population as pop
            FROM CrimeData 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            JOIN AreaLookup ON AreaLookup.Id = FK_Area_Lookup
            WHERE (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') 
                AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') 
                AND AreaLookup.Id > '.$firstId.' AND AreaLookup.Id < '.$lastId.'
                AND FK_Crime_Lookup NOT IN(10,11) GROUP BY FK_Area_Lookup
            ORDER BY NAME';
        } else {
            $query = 'SELECT ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i,DistrictLookup.Id AS area, Population as pop
            FROM CrimeData 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            JOIN DistrictLookup ON DistrictLookup.Id = FK_District_Lookup
            WHERE (CONCAT(Year,IF(Month < 10,0,""),Month) >='.$yearFrom.$monthFrom.') 
                AND (CONCAT(Year,IF(Month < 10,0,""),Month) <='.$yearTo.$monthTo.') 
                AND DistrictLookup.Id > '.$firstId.' AND DistrictLookup.Id < '.$lastId.'
                AND FK_Crime_Lookup NOT IN(10,11) GROUP BY FK_District_Lookup
            ORDER BY NAME';
        }
        
        Debugger::log('findIndexes'); 
        Debugger::log( $query ); 

        return $this->db->query( $query );
    }

    /**
    *   get all names and indexes for range of ids, used to populate select boxes at Porovnani page
    **/

    public function findNamesIndexesForIdsRange( $firstId, $lastId, $yearFrom, $monthFrom, $yearTo, $monthTo, $crimeTypes, $isDistrict )
    {   
        if( !$isDistrict ) {
            $query = 'SELECT ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i,AreaLookup.Id AS area, Name, Population as pop
            FROM CrimeData 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            JOIN AreaLookup ON AreaLookup.Id = FK_Area_Lookup
            WHERE (CONCAT(Year,IF(Month < 10,0,""),Month) >=' .$yearFrom.$monthFrom. ') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=' .$yearTo.$monthTo. ') AND FK_Crime_Lookup NOT IN(10,11) AND AreaLookup.Id > '.$firstId.' AND AreaLookup.Id < '.$lastId.' GROUP BY FK_Area_Lookup ORDER BY NAME';
        } else {
            $query = 'SELECT ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i,DistrictLookup.Id AS area, Name, Population as pop
            FROM CrimeData 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            JOIN DistrictLookup ON DistrictLookup.Id = FK_District_Lookup
            WHERE (CONCAT(Year,IF(Month < 10,0,""),Month) >=' .$yearFrom.$monthFrom. ') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=' .$yearTo.$monthTo. ') AND FK_Crime_Lookup NOT IN(10,11) AND DistrictLookup.Id > '.$firstId.' AND DistrictLookup.Id < '.$lastId.' GROUP BY FK_District_Lookup ORDER BY NAME';
        }
       
        Debugger::log('findNamesIndexesForIdsRange'); 
        Debugger::log( $query ); 

        return $this->db->query( $query );
    }

    public function findMaxDate()
    {
        return $this->db->query('SELECT Month, Year FROM TimeRange WHERE Id = (SELECT MAX(FK_Time_Range) FROM CrimeData)');
    }

    /**
    *   get ranking of all units in current level for one selected crime type
    **/

    public function getRankingsForCrimeType( $firstId, $lastId, $crimeTypeId, $yearFrom, $monthFrom, $yearTo, $monthTo)
    {
        return $this->db->query('SELECT AreaLookup.Id, Name, SUM(Vykazovane_zjisteno_mesic) AS com, SUM(Vykazovane_objasneno_mesic) AS solv,ROUND((SUM(Vykazovane_zjisteno_mesic)/(Population))*10000,0) AS i 
            FROM CrimeData 
            JOIN TimeRange ON TimeRange.Id = FK_Time_Range
            JOIN AreaLookup ON AreaLookup.Id = FK_Area_Lookup
            WHERE FK_Crime_Lookup = ' .$crimeTypeId . ' AND (CONCAT(Year,IF(Month < 10,0,""),Month) >=' .$yearFrom.$monthFrom. ') AND (CONCAT(Year,IF(Month < 10,0,""),Month) <=' .$yearTo.$monthTo. ') AND AreaLookup.Id > ' .$firstId. ' AND AreaLookup.Id < ' .$lastId. '  GROUP BY FK_Area_Lookup ORDER BY i DESC');
    }

    public function findCrimesSumForAreasTimeAndType( $firstId, $lastId, $yearFrom,$monthFrom,$yearTo,$monthTo,$crimeTypes, $isDistrict )
    {   
        if( $isDistrict ) {
            //check if need to select only certain crimeTypes
            if( empty( $crimeTypes ) || $crimeTypes == "1,2,3,4,5,6,7,8,9" ) {
                //can select all crime types ( except 10, 11 - don't apply to statistics)
                $query = 'SELECT SUM( Vykazovane_zjisteno_mesic ) as sum
                FROM CrimeData 
                JOIN DistrictLookup ON FK_District_Lookup = DistrictLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) >= ' .$yearFrom.$monthFrom. ' ) 
                AND ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) <= ' .$yearTo.$monthTo. ' ) 
                AND DistrictLookup.Id > '.$firstId.' AND DistrictLookup.Id < '.$lastId.'
                AND FK_Crime_Lookup NOT IN(10,11)
                GROUP BY FK_District_Lookup
                ORDER BY NAME';
            } else {
                //need to select only specified crimetypes
                $query = 'SELECT SUM( Vykazovane_zjisteno_mesic ) as sum
                FROM CrimeData 
                JOIN DistrictLookup ON FK_District_Lookup = DistrictLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) >=' .$yearFrom.$monthFrom. ' ) 
                AND ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) <=' .$yearTo.$monthTo. ' ) 
                AND FK_Crime_Lookup IN ( ' . $crimeTypes . ') 
                AND DistrictLookup.Id > '.$firstId.' AND DistrictLookup.Id < '.$lastId.'
                GROUP BY FK_Area_Lookup
                ORDER BY NAME';
            }
        } else {
            //check if need to select only certain crimeTypes
            if( empty( $crimeTypes ) || $crimeTypes == "1,2,3,4,5,6,7,8,9" ) {
                //can select all crime types ( except 10, 11 - don't apply to statistics)
                $query = 'SELECT SUM( Vykazovane_zjisteno_mesic ) as sum
                FROM CrimeData 
                JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) >= ' .$yearFrom.$monthFrom. ' ) 
                AND ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) <= ' .$yearTo.$monthTo. ' ) 
                AND AreaLookup.Id > '.$firstId.' AND AreaLookup.Id < '.$lastId.'
                AND FK_Crime_Lookup NOT IN(10,11)
                GROUP BY FK_Area_Lookup
                ORDER BY NAME';
            } else {
                //need to select only specified crimetypes
                $query = 'SELECT SUM( Vykazovane_zjisteno_mesic ) as sum
                FROM CrimeData 
                JOIN AreaLookup ON FK_Area_Lookup = AreaLookup.Id 
                JOIN TimeRange ON TimeRange.Id = FK_Time_Range
                WHERE ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) >=' .$yearFrom.$monthFrom. ' ) 
                AND ( CONCAT( YEAR, IF(Month < 10,0,""),Month ) <=' .$yearTo.$monthTo. ' ) 
                AND FK_Crime_Lookup IN ( ' . $crimeTypes . ') 
                AND AreaLookup.Id > '.$firstId.' AND AreaLookup.Id < '.$lastId.'
                GROUP BY FK_Area_Lookup
                ORDER BY NAME';
            }
        }
        
        
        Debugger::log('findCrimesSumForAreaTimeAndType'); 
        Debugger::log( $query ); 
        /*Debugger::log("crimeTypes");
        Debugger::log( $crimeTypes );*/
        
        return $this->db->query( $query );
    }
    
}

?>
