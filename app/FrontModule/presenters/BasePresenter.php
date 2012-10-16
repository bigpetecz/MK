<?php

/**
 * Base class for all application presenters.
 *
 * @author     Petr Velký
 * @package    MapaKriminality.cz
 */

namespace FrontModule;

use Nette\Application\UI\Form;
use Nette\Diagnostics\Debugger;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    
    /** @var string $emailFrom 
    */

    public $emailFrom = 'noreply@mapakriminality.cz';
        
	/**
	 * Sign in form component factory.
         * 
	 * @return Nette\Application\UI\Form
	 */
    
	protected function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('email', 'email')
			->setRequired('Zadejte prosím Váš e-mail.')
                        ->setAttribute('placeholder', 'e-mail');

		$form->addPassword('password', 'heslo')
			->setRequired('Zadejte prosím Vaše heslo.')
                        ->setAttribute('placeholder', 'heslo');

		//$form->addCheckbox('remember', 'Remember me on this computer');

		$form->addSubmit('login', 'PŘIHLÁSIT SE');

		$form->onSuccess[] = callback($this, 'signInFormSubmitted');
		return $form;
	}
        
        /**
         * Sign in form submit handler.
         * 
         * @param \Nette\Application\UI\Form $form
         */

	public function signInFormSubmitted(Form $form)
	{
		try {
			$values = $form->getValues();
		//	if ($values->remember) {
		//		$this->getUser()->setExpiration('+ 14 days', FALSE);
		//	} else {
				$this->getUser()->setExpiration('+ 60 minutes', TRUE);
		//	}
			$this->getUser()->login($values->email, $values->password);
			       

		} catch (\Nette\Security\AuthenticationException $e) {
			$this->flashMessage($e->getMessage(),'error');
		}
         $this->redirect('Mapa:');
	}
        
        /**
         * Registration form factory.
         * 
         * @return \Nette\Application\UI\Form
         */
        
        protected function createComponentRegistrationForm()
        {
            $form = new Form();
            
            $form->addText('email', 'email')
                    ->setRequired('Zadejte prosím Váš e-mail.')
                    ->setAttribute('placeholder', 'e-mail');
            $form->addPassword('password', 'heslo')
                    ->setRequired('Zadejte prosím Vaše heslo.')
                    ->setAttribute('placeholder', 'heslo');
            $form->addPassword('pswdCheck','potvrďte heslo')
                    ->setRequired('Potvrďte prosím Vaše heslo.')
                    ->setAttribute('placeholder', ' potvrďte heslo')
                    ->addConditionOn($form['pswdCheck'], \Nette\Application\UI\Form::FILLED)
                    ->addRule(\Nette\Application\UI\Form::EQUAL, 'Potvrdil(a) jste chybné heslo!', $form['password']);
            
            $form->addSelect('sector','sektor',$this->models->Sectors->findAll()->orderBy('name')->fetchPairs('id','name'))->setPrompt('Vyberte sektor')->setRequired('Vyberte prosím sektor.');
            
            $form->addCheckbox('newsletter','Informujte mě o aktualizacích');
            $form->addSubmit('register','REGISTROVAT');

            $form->onSuccess[] = callback($this, 'registrationSubmitted');

            return $form;
        }
        
        /**
         * Registration form submit handler.
         * 
         * @param \Nette\Application\UI\Form $form
         */

        
        public function registrationSubmitted(Form $form)
        {
            $values = $form->getValues();
            unset($values['pswdCheck']);
            $values['date_last_login'] = date('Y-m-d H:i:s');
            $values['password'] = $this->models->Users->calculateHash($values['password']);
            $this->models->Users->insert($values);
            
            $this->flashMessage('Registrace byla dokončena.','success');
            $this->redirect('Mapa:');
            
        }
        
        /**
         * Userinfo form factory.
         * 
         * @return \Nette\Application\UI\Form
         */
        
        protected function createComponentUserInfoForm()
        {
            $form = new Form();
            $form->addText('email', 'email')->setDisabled();
            $form->addPassword('password', 'heslo')
                    ->setAttribute('placeholder', 'heslo');
            $form->addPassword('checkPassword', 'potvrdit')
                                ->setAttribute('placeholder', 'potvrdit heslo')
                    ->addConditionOn($form['checkPassword'], Form::FILLED)
					->addRule(Form::EQUAL, 'Potvrdil(a) jste chybné heslo!', $form['password']);
            $form->addSelect('sector','sektor',$this->models->Sectors->findAll()->orderBy('name')->fetchPairs('id','name'))->setPrompt('Vyberte');
            
            $form->addCheckbox('newsletter','Informujte mě o aktualizacích');
            $form->addSubmit('save','ULOŽIT ZMĚNY');

            $form->onSuccess[] = callback($this, 'userInfoSubmitted');
            
            if($this->user->isLoggedIn())
                $form->setDefaults($this->models->Users->find($this->user->getId())->fetch());
            
            
            
            return $form;
        }

        /**
         * Userinfo form submit handler.
         * 
         * @param \Nette\Application\UI\Form $form
         */
        
        public function userInfoSubmitted(Form $form)
        {
            
            $values = $form->getValues();
            unset($values['email']);
            unset($values['checkPassword']);
            if(empty($values['password']))
                unset($values['password']);
            else
                $values['password'] = $this->models->Users->calculateHash($values['password']);
            $this->models->Users->update($values,$this->user->getId());
          
            $this->flashMessage('Vaše údaje byly upraveny.','success');
            $this->redirect('Mapa:');
        }
        
        
        /**
         * Forget password form factory.
         * 
         * @return \Nette\Application\UI\Form
         */

        protected function createComponentForgetPassForm()
        {
            $form = new Form();
            
            $form->addText('email','Váš e-mail zadaný při registraci');
            $form->addSubmit('submit','Odeslat');
            $form->onSuccess[] = callback($this,'forgetPassSubmitted');
            return $form;
        }
        
        /**
         * Forget password form submit handler.
         * 
         * @param \Nette\Application\UI\Form $form
         */
        
        public function forgetPassSubmitted(Form $form)
        {
            $values = $form->getValues();
            
            $row = $this->models->Users->findEmail($values['email'])->fetch();
            
            if($row)
            {
                $newPass = \Nette\Utils\Strings::random(5);
                $this->models->Users->update(array('password'=>$this->models->Users->calculateHash($newPass)),$row->id);
                
                $mail = new \Nette\Mail\Message();
                $mail->setFrom($this->emailFrom);

                $mail->addTo($values['email']);
                $mail->setSubject('MapaKriminality.cz - Nové heslo');
                $mail->setHtmlBody("<p>Dobrý den,</p><p>k Vašemu účtu ".$values['email']." Vám bylo vygerenováno nové heslo: ".$newPass."</p>");
                try{
                    $mail->send();
                }
                catch(Exception $e)
                {
                    error_log($e->getMessage());
                }
                
                $this->flashMessage('Byl Vám odeslán e-mail s novým heslem.','success');
            }
            else
            {
                $this->flashMessage('Účet s tímto e-mailem nebyl dosud registrován.','error');
            }
            $this->redirect('this');
        }
        
        /**
         * Model loader.
         * 
         * @return \ModelLoader
         */
        
        
        final public function getModels()
        {
            return $this->context->modelLoader;
        }
        
        
        
        public function handleImportCrime()
        {
            
           $filename = WWW_DIR. '/crimedata.csv';
                $file_handle = fopen($filename,'r');
                $row = 1;
                while (!feof($file_handle) ) 
                {   
                    $data = fgetcsv($file_handle,5096,',');
 
               $row = array(
                   'Id'=>$data[0],
                   'Vykazovane_zjisteno_mvcr'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[1])),
                   'Vykazovane_objasneno_mvcr'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[2])),
                   'FK_Crime_Lookup'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[3])),
                   'FK_Area_Lookup'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[4])),
                   'FK_Time_Range'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[5])),
                   'Vykazovane_zjisteno_mesic'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[6])),
                   'Vykazovane_objasneno_mesic'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[7]))                   
               );
               $this->models->CrimeData->insert($row);
               $row++;
               
                }
        }
        
                
        
        public function handleImportDamage()
        {
           $filename = WWW_DIR. '/damagedata.csv';
                $file_handle = fopen($filename,'r');
                $row = 1;
                while (!feof($file_handle) ) 
                {   
                    $data = fgetcsv($file_handle,5096,',');
                    if(!empty($data[1]))
                    {
                        $row = array(
                            'Id'=>\Nette\Utils\Strings::webalize($data[0]),
                            'Vykazovane_celkem_mvcr'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[1])),
                            'Vykazovane_odcizeno_mvcr'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[2])),
                            'Vykazovane_zajisteno_mvcr'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[3])),
                            'Vykazovane_celkem_mesic'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[4])),
                            'Vykazovane_odcizeno_mesic'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[5])),
                            'Vykazovane_zajisteno_mesic'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[6])),
                            'FK_Crime_Lookup'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[7])),
                            'FK_Area_Lookup'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[8])),
                            'FK_Time_Range'=>iconv('WINDOWS-1250','UTF-8', \Nette\Utils\Strings::webalize($data[9])),
                        );
                        $this->models->DamageData->insert($row);
                        $row++;
                    }
            }
                        
        }
        
        /**
         * Handler for retreive map data in json.
         * 
         * @param int $area
         * @param int $crime
         * @param string $yearFrom
         * @param string $monthFrom
         * @param string $yearTo
         * @param string $monthTo
         * @param string $crimeTypes
         */
        
        public function handleLoadData($area,$crime,$yearFrom,$monthFrom,$yearTo,$monthTo,$crimeTypes,$isDistrict)
        {
            if($monthFrom < 10)
            {
                $monthFrom = '0'.$monthFrom;
            }
            if($monthTo < 10)
            {
                $monthTo = '0'.$monthTo;
            }
            
            if(isset($area) && isset($crime))
            {
                $data = $this->models->CrimeData->findAreaCrimes($area,$yearFrom,$monthFrom,$yearTo,$monthTo,$isDistrict)->fetchAll();
                $json = array();
                $com = 0;
                foreach($data as $d)
                {
                    $json[$d->crime] = array(!empty($d->com) ? $d->com:0,!empty($d->solv) ? $d->solv:0, \Nette\Utils\Strings::normalize($d->area),!empty($d->i) ? $d->i:0);           
                    $com += $d->com;
                }
                echo json_encode($json);
            }
            elseif(isset($area))
            {
                $data = $this->models->CrimeData->findAreaTotal( $area,$yearFrom,$monthFrom,$yearTo,$monthTo,$crimeTypes,$isDistrict )->fetch();
                $json = array(!empty($data->com) ? $data->com:'data nejsou k dispozici',!empty($data->solv) ? $data->solv:'data nejsou k dispozici', !empty($data->i) ? $data->i:'data nejsou k dispozici', !empty($data->selected) ? $data->selected:'data nejsou k dispozici');           
                
                echo json_encode($json);
            }
            else
            {
                echo 'data nejsou k dispozici';
            }
            $this->terminate();
        }
        
        /**
         * Handler for retreive data for comparation.
         * 
         * @param string $area
         * @param string $yearFrom
         * @param string $monthFrom
         * @param string $yearTo
         * @param string $monthTo
         */
        
        public function handleLoadCompare($area,$yearFrom,$monthFrom,$yearTo,$monthTo)
        {
            if($monthFrom < 10)
            {
                $monthFrom = '0'.$monthFrom;
            }
            if($monthTo < 10)
            {
                $monthTo = '0'.$monthTo;
            }
            if(empty($area))
                $area = 'Celá ČR';
            
            $data = $this->models->CrimeData->findNameCrimes($area,$yearFrom,$monthFrom,$yearTo,$monthTo)->fetchAll();
            $json = array();
                
            $totalIndex = $this->models->CrimeData->findAreaTotal($data[0]->AreaId,$yearFrom,$monthFrom,$yearTo,$monthTo)->fetch()->i;
            
            foreach($data as $d)
            {
                $json[$d->crime] = array(!empty($d->com) ? $d->com:0,!empty($d->solv) ? $d->solv:0, \Nette\Utils\Strings::normalize($d->area),!empty($d->i) ? $d->i:0,$totalIndex);           
            }
            echo json_encode($json);
            
 
            $this->terminate();
        }
        
        /**
         * Handler or retreive data for timeline.
         */
        
        public function handleLoadTimeline( $crimeTypes )
        {
            $data = $this->models->CrimeData->findTimeline( $crimeTypes )->fetchAll();
            $output = array();
            foreach($data as $row)
            {
                $output['data'][] = array('date'=>\Nette\Utils\Strings::firstUpper(monthCZ(sprintf("%02s", $row->Month))).' '.$row->Year,'abs'=>$row->abs );
                
            }
            echo json_encode($output);
            $this->terminate();
        }
        
        /**
         * 
         * 
         * @param type $yearFrom
         * @param string $monthFrom
         * @param type $yearTo
         * @param string $monthTo
         */

        public function handleLoadMapValuesStyles($zoomLevel, $yearFrom = 2010,$monthFrom = 1,$yearTo = 2012,$monthTo = 12, $crimeTypes)
        {
            if($monthFrom < 10) {
                $monthFrom = '0'.$monthFrom;
            }

            if($monthTo < 10) {
                $monthTo = '0'.$monthTo;
            }

            $isDistrict = false;
            
            if( $zoomLevel == 0 ) {
                $id1 = 0;
                $id2 = 16;
            } else if( $zoomLevel == 1) {
                $id1 = 1;
                $id2 = 16;
            } else if( $zoomLevel == 2 ) {
                $id1 = 0;
                $id2 = 87;
                $isDistrict = true;
            }
            
            //get sum of crimes for index computation
            $crimesSums = $this->models->CrimeData->findCrimesSumForAreasTimeAndType( $id1, $id2, $yearFrom, $monthFrom, $yearTo, $monthTo, $crimeTypes, $isDistrict )->fetchAll();
            $data = $this->models->CrimeData->findIndexes( $id1, $id2, $yearFrom, $monthFrom, $yearTo, $monthTo, $isDistrict )->fetchAll();
            
            $output = array();
            $index = 0;
            
            foreach( $data as $d )  {
                if(isset($crimesSums[$index]))
                    $sum = $crimesSums[ $index ]->sum;
                else
                    $sum = 0;
                $population = $d->pop;
                $multiplier = 10000;
                if( $population < 10 ) $population = 30000;
                $i = ( $sum / $population ) * $multiplier;
                Debugger::log("name: " . $d->area . ", sum: " . $sum . ", pop: " . $population . ", i: " .$i ); 
                //$index = $this->models->CrimeData->computeIndex( $sum, $population );
                
                
                array_push( $output, array("i" => $i, "area" => $d->area, "sum" => $sum, "pop" => $population ) );
                $index++;
            }
            
            echo json_encode( $output );
            $this->terminate();
        }
        
        /**
         * 
         * 
         * @param type $zoomLevel
         * @param type $yearFrom
         * @param string $monthFrom
         * @param type $yearTo
         * @param string $monthTo
         */

        public function handleFindNamesIndexesForIdsRange($zoomLevel,$yearFrom = 2010,$monthFrom = 1,$yearTo = 2012,$monthTo = 12, $crimeTypes)
        {
            
            if($monthFrom < 10)
            {
                $monthFrom = '0'.$monthFrom;
            }
            if($monthTo < 10)
            {
                $monthTo = '0'.$monthTo;
            }

            $id1 = 0;
            $id2 = 2;
            $isDistrict = false;
            
            if($zoomLevel == 1) {
                $id1 = 1;
                $id2 = 16;
            } else if ( $zoomLevel == 2 ) {
                $id1 = 1;
                $id2 = 86;
                $isDistrict = true;
            }
            
            //get sum of crimes for index computation
            $crimesSums = $this->models->CrimeData->findCrimesSumForAreasTimeAndType( $id1, $id2, $yearFrom, $monthFrom, $yearTo, $monthTo, $crimeTypes, $isDistrict )->fetchAll();
            $data = $this->models->CrimeData->findNamesIndexesForIdsRange($id1,$id2,$yearFrom,$monthFrom,$yearTo,$monthTo, $crimeTypes, $isDistrict)->fetchAll();
            
            $output = array();
            $index = 0;
            
            foreach( $data as $d )  {   
                if(isset($crimesSums[$index]))
                    $sum = $crimesSums[ $index ]->sum;
                else
                    $sum = 0;
                $population = $d->pop;
                $multiplier = 10000;
                if( $population < 10 ) $population = 30000;
                $i = ( $sum / $population ) * $multiplier;
                array_push( $output, array("Name" => $d->Name, "i" => $i, "area" => $d->area, "sum" => $sum, "pop" => $population ) );
                //array_push( $output, array( "i" => $d ) );
                $index++;
            }

            //echo json_encode( $data );
            echo json_encode( $output );
            $this->terminate();
        }
        
        public function handleGetDamage($area,$monthFrom,$yearFrom,$monthTo,$yearTo,$filters)
        {
            $data = $this->models->DamageData->findTotalFromArea($area,$monthFrom,$yearFrom,$monthTo,$yearTo,$filters)->fetchSingle();
            
            echo json_encode($data);
            
            $this->terminate();
        }

        public function handleGetRankingsForCrimeType( $zoomLevel, $crimeTypeId, $yearFrom = 2010, $monthFrom = 1, $yearTo = 2012, $monthTo = 12 )
        {
            if($monthFrom < 10)  {
                $monthFrom = '0'.$monthFrom;
            }
            
            if($monthTo < 10) {
                $monthTo = '0'.$monthTo;
            }

            $id1 = 0;
            $id2 = 2;
            
            if($zoomLevel == 1) {
                $id1 = 1;
                $id2 = 16;
            } 

            $data = $this->models->CrimeData->getRankingsForCrimeType( $id1, $id2, $crimeTypeId, $yearFrom, $monthFrom, $yearTo, $monthTo )->fetchAll();
            //array_push( $data, $yearTo.$monthTo );
            echo json_encode($data);
            
            $this->terminate();
        }
}
