<?php

    class translator extends CI_Model {

        public $cur_lang = 'en';
        public $short = 280;

        function __construct()
        {
            parent::__construct(); 
            $this->setCurLang();
        }

        public function setCurLang($lang = 'sr') {
            $this->cur_lang = $lang;
        }

        public function sr($page, $item) {

            $array['page']['title'] = '';
            $array['page']['description'] = '';

            $array['home']['title'] = 'Dobrodošli';
            $array['home']['description'] = 'Nasa uspesna iskustva u izradi softverskih aplikacija su omogucila nasim klijentima da povecaju prednost nad konkurencijom i steknu operativnu superiornost';

            $array['about']['title'] = 'Comapny Profile';
            $array['about']['description'] = 'Logic Solutions is an IT company that deals with the introduction and maintenance of modern information systems based on databases and advanced technologies, the latest generation.';

            $array['solutions']['title'] = 'Solutions';
            $array['solutions']['description'] = "Logic Solution offers modular solutions, easy to use and update to the customer's needs. The practice has taught us that the online information system solution is the most reliable solution that promotes and facilitates the operations of a company.";

            $array['participant']['title'] = 'Participant';
            $array['participant']['description'] = 'Participant manager is a user friendly on-line registration management solution including a unique on-site management tool. It encompasses the entire registration management process from on-line to on-site and has been used to manage events from 1-2,000 participants. ';

            $array['abstract']['title'] = 'Abstract';
            $array['abstract']['description'] = 'Abstract manager is a user friendly on-line abstract submission and programme management tool. The complete abstract management process can be controlled including form creation with complete event branding, abstract submission, author login, abstract reviewing, abstract scoring, session scheduling, abstract publishing and reporting. ';

            $array['exhibitor']['title'] = 'Exhibitor';
            $array['exhibitor']['description'] = 'Exhibitor manager is a user friendly on-line exhibition and tradeshow management solution. Through Exhibitor manager, exhibitors can select and book stand space as well as order additional items to furnish their stand - all through an on-line booking form and account. ';

            $array['services']['title'] = 'Services';
            $array['services']['description'] = 'We provide consultancy and programming services to our clients as an Offshore Application Development Center.';

            $array['app_developement']['title'] = 'Application Development';
            $array['app_developement']['description'] = 'Logic Solution  has a well-defined and mature application development process which comprises the complete Software Development Life Cycle (SDLC) from business case analysis to warranty support of the application.';

            $array['custom_web_app']['title'] = 'Custom Web Application';
            $array['custom_web_app']['description'] = 'Our talented software professionals have years of experience in developing customized software applications for small and mid-level businesses.'; 

            $array['hire_php']['title'] = 'Hire PHP Developer';
            $array['hire_php']['description'] = 'Offshoring your development and designing projects to experts who can handle the tasks efficiently, integrate technology and innovative minds, give above expectations results in a defined time frame is why you must hire a dedicated team of developers from Logic Solution.';

            $array['it_consulting']['title'] = 'IT Consulting';
            $array['it_consulting']['description'] = 'Our Consulting Team can help your IT projects succeed with proven, robust architectures, data-driven software development, and strong project management. We speak IT and business languages fluently.';

            $array['qa_services']['title'] = 'Quality Assurance';
            $array['qa_services']['description'] = 'Quality Assurance (QA) and testing services at Logic Solution ensure that applications are rigorously tested using industry - standard testing methods and QA processes. Offshore software testing includes all the verification and validation activities done on software product to ensure end product quality.';

            $array['seo_services']['title'] = 'Seo Services';
            $array['seo_services']['description'] = 'Logic Solution offers Search Engine Optimization services to all type of websites. Search Engine Optimization is the only way to get the most benefit of your website. ';

            $array['web_solutions']['title'] = 'Web Solutions';
            $array['web_solutions']['description'] = 'Logic Solution takes care of all aspects of web design. ';

            $array['jobs']['title'] = 'Jobs';
            $array['jobs']['description'] =  'During the last year we were able to respond to the demands of our clients and perform tasks that are asked of us. Due to increased workload, Logic Solution opens a new position for a Junior PHP developer.';

            $array['sitemap']['title'] = 'Sitemap';
            $array['sitemap']['description'] =  'Solutions, services, contact';                        

            return $array[$page][$item];

        }

        public function en($page, $item) {

            $array['page']['title'] = '';
            $array['page']['description'] = '';

            $array['home']['title'] = 'Welcome';
            $array['home']['description'] = 'Logic Solution shares your entrepreneurial spirit. Our solution give you the freedom to focus on adding value to your buisness.';

            $array['about']['title'] = 'Comapny Profile';
            $array['about']['description'] = 'Logic Solutions is an IT company that deals with the introduction and maintenance of modern information systems based on databases and advanced technologies, the latest generation.';

            $array['solutions']['title'] = 'Solutions';
            $array['solutions']['description'] = "Logic Solution offers modular solutions, easy to use and update to the customer's needs. The practice has taught us that the online information system solution is the most reliable solution that promotes and facilitates the operations of a company.";

            $array['participant']['title'] = 'Participant';
            $array['participant']['description'] = 'Participant manager is a user friendly on-line registration management solution including a unique on-site management tool. It encompasses the entire registration management process from on-line to on-site and has been used to manage events from 1-2,000 participants. ';

            $array['abstract']['title'] = 'Abstract';
            $array['abstract']['description'] = 'Abstract manager is a user friendly on-line abstract submission and programme management tool. The complete abstract management process can be controlled including form creation with complete event branding, abstract submission, author login, abstract reviewing, abstract scoring, session scheduling, abstract publishing and reporting. ';

            $array['exhibitor']['title'] = 'Exhibitor';
            $array['exhibitor']['description'] = 'Exhibitor manager is a user friendly on-line exhibition and tradeshow management solution. Through Exhibitor manager, exhibitors can select and book stand space as well as order additional items to furnish their stand - all through an on-line booking form and account. ';

            $array['services']['title'] = 'Services';
            $array['services']['description'] = 'We provide consultancy and programming services to our clients as an Offshore Application Development Center.';

            $array['app_developement']['title'] = 'Application Development';
            $array['app_developement']['description'] = 'Logic Solution  has a well-defined and mature application development process which comprises the complete Software Development Life Cycle (SDLC) from business case analysis to warranty support of the application.';

            $array['custom_web_app']['title'] = 'Custom Web Application';
            $array['custom_web_app']['description'] = 'Our talented software professionals have years of experience in developing customized software applications for small and mid-level businesses.'; 

            $array['hire_php']['title'] = 'Hire PHP Developer';
            $array['hire_php']['description'] = 'Offshoring your development and designing projects to experts who can handle the tasks efficiently, integrate technology and innovative minds, give above expectations results in a defined time frame is why you must hire a dedicated team of developers from Logic Solution.';

            $array['it_consulting']['title'] = 'IT Consulting';
            $array['it_consulting']['description'] = 'Our Consulting Team can help your IT projects succeed with proven, robust architectures, data-driven software development, and strong project management. We speak IT and business languages fluently.';

            $array['qa_services']['title'] = 'Quality Assurance';
            $array['qa_services']['description'] = 'Quality Assurance (QA) and testing services at Logic Solution ensure that applications are rigorously tested using industry - standard testing methods and QA processes. Offshore software testing includes all the verification and validation activities done on software product to ensure end product quality.';

            $array['seo_services']['title'] = 'Seo Services';
            $array['seo_services']['description'] = 'Logic Solution offers Search Engine Optimization services to all type of websites. Search Engine Optimization is the only way to get the most benefit of your website. ';

            $array['web_solutions']['title'] = 'Web Solutions';
            $array['web_solutions']['description'] = 'Logic Solution takes care of all aspects of web design. ';

            $array['jobs']['title'] = 'Jobs';
            $array['jobs']['description'] =  'During the last year we were able to respond to the demands of our clients and perform tasks that are asked of us. Due to increased workload, Logic Solution opens a new position for a Junior PHP developer.';

            $array['sitemap']['title'] = 'Sitemap';
            $array['sitemap']['description'] =  'Solutions, services, contact';                        

            return $array[$page][$item];

        }

        public function getMeta($page,$lang,$item) {
            switch($lang) {
                case 'sr' :
                    return substr($this->sr($page,$item),0,$this->short);
                    break;           
                case 'en':
                    return substr($this->en($page,$item),0,$this->short);
                    break;           
                default:
                case 'en':
                    return substr($this->en($page,$item),0,$this->short);
                    break;
            }
        }

        public function getKeywords($lang){

            switch($lang) {
                case 'sr' :
                    return 'letovanje crna gora, aranzmani crna gora, smjestaj, smjestaj u budvi, smjestaj u crnoj gori, transferi crna gora, izleti crna gora, ture crna gora, privatna putovanja, crna gora hoteli, hoteli u crnoj gori, crna gora hotel, budva hoteli, smjestaj budva, rentacar crna gora, crna gora';
                    break;           
                case 'en':
                    return 'Application development, application development services, application development company, Software Application Development, Offshore Application Development, Application Development Outsourcing, Software Services Serbia';
                    break;            
                default:
                    return 'Application development, application development services, application development company, Software Application Development, Offshore Application Development, Application Development Outsourcing, Software Services Serbia';
                    break;
            }

        }

        public function getStyles($lang){

            switch($lang) {
                case 'sr' :
                    return '.menu { padding:0 0 0 0;}.menu li a {padding: 0 14px;}';
                    break;            
                case 'en':
                    return '.menu { padding:0 0 0 0;}.menu li a {padding: 0 9px;}';
                    break;            
                default:
                    return '.menu { padding:0 0 0 5px;}.menu li a {padding: 0 9px;}';
                    break;
            }

        }



    }
?>