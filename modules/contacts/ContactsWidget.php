<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/18/2017
 * Time: 2:22 PM
 */

namespace modules\contacts;
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

use framework\core\User;

class ContactsWidget {

    public function __construct(User &$USER) {

        $REL = new Relation($USER);
        $myContacts = new MyContacts();
        $myRequests = new ContactRequests();
        $sentRequests = $myRequests->sentRequests($REL);
        $incomingRequests = $myRequests->getRequests($REL);
        $contactRows = $myContacts->getContactList($USER, $REL);
        $numContacts = $REL->getNumContacts();
        echo <<<HTML


<div id="contactWidget" class="container-fluid contactContainer" >
    <div class="contactPanel">
        <div class="contactHeader">
            <span class="pull-left">
                <ul class="contactSubHeader nav nav-tabs">
                    <li class="active">
                        <a id="openContacts" data-toggle="tab" href="#home" class="panelBtn">
                            <span class="tabIcon glyphicon glyphicon-user"></span>
                            <span class="label label-success"> (1/$numContacts) </span>
                            
                        </a>
                    </li>
                    <li>
                        <a id="openMessages" data-toggle="tab" href="#menu1" class="panelBtn">
                            <span class="tabIcon glyphicon glyphicon-envelope"></span>
                            <span class="label label-primary"> 
                                12 
                            </span>
                        </a>
                    </li>
                    <li>
                        <a id="openRequests" data-toggle="tab" href="#menu2" class="panelBtn">
                            <span class="tabIcon glyphicon glyphicon-flag"></span>
                            <span class="label label-success"> 2 </span>
                        </a>
                    </li>
                    <li>
                        <a id="openRequests" data-toggle="tab" href="#search" class="panelBtn">
                            <span class="tabIcon glyphicon glyphicon-search"></span>
                            
                        </a>
                    </li>
                </ul>
            </span>
            
            <button id="closeContactWidget" class="widgetBtn pull-right">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
            <button id="contactListBtn" data-toggle="collapse" data-target=".contactList" class="widgetBtn collapsed pull-right">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </div>
        
        <div class="panel-body contactList collapse in contact-wgt-body">
            
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h5> Contacts </h5>
                    <table class="table table-responsive contactTable">
                        $contactRows
                    </table>
                </div>
                <div id="menu1" class="tab-pane fade">
                     <h5> Messages </h5>
                </div>
                <div id="menu2" class="tab-pane fade">
                   <h5>  New Requests </h5>
                    <table class="table table-responsive contactTable">
                        $incomingRequests
                    </table>
                    
                    <div class="divider"></div>
                    <h5> Sent Requests </h5>
                    <table class="table table-responsive contactTable">
                        $sentRequests
                    </table>
                </div>
                <div id="search" class="tab-pane fade">
                    <input type="text" id="searchUsers" placeholder="Search for new contacts: " />
                    <table id="searchResults" class="table table-responsive contactTable">
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div id="chatBoxes">

</div>
HTML;
        // return (string) $widget;
    }

}




