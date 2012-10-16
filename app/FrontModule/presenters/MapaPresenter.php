<?php

/**
 * Mapa presenter.
 *
 * @author     Petr Velký
 * @package    MapaKriminality.cz
 */

namespace FrontModule;

use Nette\Application\UI\Form;

class MapaPresenter extends BasePresenter
{

        /**
         * Presenter action Default.
         */
    
	public function actionDefault()
	{
            $first = 2010;
            $years = array();
            for($y=$first; $y<=date('Y'); $y++)
            $years[] = $y;
            
            
            $this->template->years = $years;
            
                
            $session = $this->session->getSection('map');
            
         /*   unset($session->area);
            unset($session->table);
            unset($session->filters);
            unset($session->dateFrom);
            unset($session->dateTo);
           */ 
            
            if(isset($session->area))
            {
                $this->template->area = $session->area;
            }
            else
            {
                $this->template->area = "null";
            }
            
            
            if(isset($session->table))
            {
                $this->template->table = $session->table;
            }
            else
            {
                $this->template->table = 'countyTable'; 
            }
            
            if(isset($session->filters))
            {
                $this->template->filters = $session->filters;
                
            }
            else
            {
                $this->template->filters = null;
            }
            
            $to = $this->models->CrimeData->findMaxDate()->fetch();
            
            if(isset($session->dateFrom))
            {
                $this->template->firstDate = array('year'=>$session->dateFrom['Year'],'month'=>$session->dateFrom['Month']);
                $this->template->defaultMonth =  \Nette\Utils\Strings::firstUpper(monthCZ($session->dateTo['Month'] < 10 ? '0'.$session->dateTo['Month']:$session->dateTo['Month']));   
            }
            else
            {
                //augment month to have 12 months period
                $monthFrom = ( $to->Month < 12 ) ? $to->Month + 1 : 1;
                $yearFrom = ( $to->Month < 12 ) ? $to->Year - 1 : $to->Year;
            
                $to = $this->models->CrimeData->findMaxDate()->fetch();
                //$this->template->firstDate = array('year'=>$to->Year-1,'month'=>$to->Month);
                $this->template->firstDate = array( 'year'=>$yearFrom , 'month'=>$monthFrom );
                //$this->template->defaultMonth=  \Nette\Utils\Strings::firstUpper(monthCZ($to->Month < 10 ? '0'.$to->Month:$to->Month));
                $this->template->defaultFromMonth = \Nette\Utils\Strings::firstUpper(monthCZ( $monthFrom < 10 ? '0'.$monthFrom : $monthFrom ));
            }
            if(isset($session->dateTo))
            {
                $this->template->secondDate = array('year'=>$session->dateTo['Year'],'month'=>$session->dateTo['Month']);
                $this->template->defaultMonth =  \Nette\Utils\Strings::firstUpper(monthCZ($session->dateTo['Month'] < 10 ? '0'.$session->dateTo['Month']:$session->dateTo['Month']));
            }
            else
            {   
                $monthTo = $to->Month;
                $yearTo = $to->Year;
            
                
                //$this->template->secondDate = array('year'=>$to->Year,'month'=>$to->Month);
                $this->template->secondDate = array( 'year'=>$yearTo , 'month'=>$monthTo );
                //$this->template->defaultMonth=  \Nette\Utils\Strings::firstUpper(monthCZ($to->Month < 10 ? '0'.$to->Month:$to->Month));
                $this->template->defaultToMonth = \Nette\Utils\Strings::firstUpper(monthCZ( $monthTo < 10 ? '0'.$monthTo : $monthTo ));
            }
        }
        
        /**
         * Contact form factory.
         * 
         * @return \Nette\Application\UI\Form
         */
        
        
        protected function createComponentContactForm()
        {
            $form = new Form();
            $form->getElementPrototype()->setClass('contactForm');
            $form->addText('name','Jméno')->setAttribute('placeholder','Jméno');
            $form->addText('email','E-mail')->setAttribute('placeHolder','E-mail')->setRequired('Zadejte prosím Váš e-mail.');
            $form->addHidden('emailTo');
            $form->addTextarea('message')->setAttribute('placeholder','Zpráva');
            $form->addSubmit('send','ODESLAT')->getControlPrototype()->setClass('web');
            
            $form->onSuccess[] = callback($this, 'contactSubmitted');
            
            return $form;
        }
        
        /**
         * Contact form factory.
         * 
         * @param \Nette\Application\UI\Form $form
         */
        
        public function contactSubmitted(Form $form)
        {
            $values = $form->getValues();
            $mail = new \Nette\Mail\Message();
            $mail->setFrom($values['email']);

            $mail->addTo($values['emailTo']);
            $mail->setSubject('Nová zpráva z portálu mapakriminality.cz');
            $mail->setBody($values['message']);
            try{
                $mail->send();
            }
            catch(\Nette\InvalidStateException $e)
            {
                error_log($e->getMessage());
            }

            $this->flashMessage('Vaše zpráva byla odeslána.','success');
        }
        
        /**
         * Handler for timelane setup storage into sessions.
         * 
         * @param string $yearFrom
         * @param string $monthFrom
         * @param string $yearTo
         * @param string $monthTo
         */
        
        
        public function handleStoreDate($yearFrom,$monthFrom,$yearTo,$monthTo)
        {
            $session = $this->session->getSection('map');
            
            $session->dateFrom = array('Year'=>$yearFrom,'Month'=>$monthFrom);
            $session->dateTo = array('Year'=>$yearTo,'Month'=>$monthTo);
                        
            $this->terminate();
        }
        
        /**
         * Handler for storing selected table type into sessions.
         * 
         * @param string $table
         */
        
        public function handleStoreTable($table)
        {
            $session = $this->session->getSection('map');
            $session->table = $table;
            
            $this->terminate();
        }
        
        /**
         * Handler for storing selected area.
         * 
         * @param int $area
         */
        
        public function handleStoreArea($area)
        {
            $session = $this->session->getSection('map');
            $session->area = $area;
            
            $this->terminate();
        }
        
        /**
         * Handler for storing filters.
         * 
         * @param string $filters
         */
        
        public function handleStoreFilters($filters)
        {
            $session = $this->session->getSection('map');
            $session->filters = $filters;
            
            $this->terminate();
        }
        
}
