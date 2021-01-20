<?php
namespace Vanestarre\Controller;

use Vanestarre\Model\VanestarreConfig;

/**
 * Class ModifConfigController
 *
 * Used to change the json config file
 *
 * @author CHATEAUX Adrien
 * @package Vanestarre\Controller
 */
class ModifConfigController implements IController
{
    /**
     * @inheritDoc
     */
    public function execute() {
        $nbr_messages_par_page = $_GET['nbr_messages_par_page'];
        $nbr_min_react_pour_event = $_GET['nbr_min_react_pour_event'];
        $nbr_max_react_pour_event = $_GET['nbr_max_react_pour_event'];

        if(is_numeric($nbr_messages_par_page) && is_numeric($nbr_min_react_pour_event) && is_numeric($nbr_max_react_pour_event))
        {
            $config = new VanestarreConfig();

            $config->set_nbr_messages_par_page($nbr_messages_par_page);
            $config->set_love_lim_inf($nbr_min_react_pour_event);
            $config->set_love_lim_sup($nbr_max_react_pour_event);

            $config->save_config();
        }
        else
        {
            http_response_code(401);
        }

        header('Location: /config');
    }

    /**
     * @inheritDoc
     */
    public function get_title(): string {
        return 'Modif Config';
    }

    /**
     * @inheritDoc
     */
    public function get_stylesheets(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function get_scripts(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function needs_standard_layout(): bool {
        return false;
    }
}
?>