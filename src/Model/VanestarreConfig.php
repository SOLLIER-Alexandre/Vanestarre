<?php

    namespace Vanestarre\Model;

    /**
    * Class VanestarreConfig
    *
    * Configurations for pages and donations
    *
    * @author CHATEAUX Adrien
    * @package Vanestarre\Model
    */
    class VanestarreConfig
    {
        private $config_filename;

        /**
         * @var int $nbr_messages_par_page The number of messages displayed for each page of the HomeView
         */
        private $nbr_messages_par_page;

        /**
         * @var int $love_lim_inf The minimum number of love reactions needed for the random forced donation event
         */
        private $love_lim_inf;

        /**
         * @var int $love_lim_sup The maximum number of love reactions needed for the random forced donation event
         */
        private $love_lim_sup;

        /**
         * Constructs a config
         */
        public function __construct()
        {
            $this->config_filename = $_SERVER["DOCUMENT_ROOT"] . "/VanestarreConfig.json";
            
            if(file_exists($this->config_filename))
            {
                $this->load_config();
            }
            else
            {
                $this->nbr_messages_par_page = 2;
                $this->love_lim_inf = 1;
                $this->love_lim_sup = 10;
            }
        }

        /**
         * @return int $nbr_messages_par_page The number of messages displayed for each page of the HomeView
         */
        public function get_nbr_messages_par_page(): int
        {
            return $this->nbr_messages_par_page;
        }

        /**
         * @return int $love_lim_inf The minimum number of love reactions needed for the random forced donation event
         */
        public function get_love_lim_inf(): int
        {
            return $this->love_lim_inf;
        }

        /**
         * @return int $love_lim_sup The maximum number of love reactions needed for the random forced donation event
         */
        public function get_love_lim_sup(): int
        {
            return $this->love_lim_sup;
        }

        /**
         * @param int $nbr_messages_par_page The number of messages displayed for each page of the HomeView
         */
        public function set_nbr_messages_par_page(int $nbr_messages_par_page): void
        {
            $this->nbr_messages_par_page = $nbr_messages_par_page;
        }

        /**
         * @param int $love_lim_inf The minimum number of love reactions needed for the random forced donation event
         */
        public function set_love_lim_inf(int $love_lim_inf): void
        {
            $this->love_lim_inf = $love_lim_inf;
        }

        /**
         * @param int $love_lim_sup The maximum number of love reactions needed for the random forced donation event
         */
        public function set_love_lim_sup(int $love_lim_sup): void
        {
            $this->love_lim_sup = $love_lim_sup;
        }

        /**
         * Saves the current configuration in a json file named VanestarreConfig
         */
        public function save_config(): void
        {
            $configs['nbr_messages_par_page'] = $this->nbr_messages_par_page;
            $configs['love_lim_inf'] = $this->love_lim_inf;
            $configs['love_lim_sup'] = $this->love_lim_sup;

            $configs_json = json_encode($configs);

            $file = fopen($this->config_filename, "w");
            fwrite($file, $configs_json);
            fclose($file);
        }

        /**
         * Loads the configuration from the json file VanestarreConfig to the current configuration
         */
        public function load_config(): void
        {
            $file = fopen($this->config_filename, "r");
            $configs_json = fread($file, "100");
            fclose($file);

            $configs = json_decode($configs_json);

            $this->set_nbr_messages_par_page($configs['nbr_messages_par_page']);
            $this->love_lim_inf($configs['love_lim_inf']);
            $this->love_lim_sup($configs['love_lim_sup']);
        }
    }