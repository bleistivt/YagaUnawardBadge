<?php

$PluginInfo['YagaUnawardBadge'] = array(
    'Name' => 'Yaga Unaward Badge',
    'Description' => 'Adds the option for users that can give out badges to take them away.',
    'Version' => '0.2',
    'RequiredApplications' => array('Yaga' => '1.0'),
    'MobileFriendly' => true,
    'Author' => 'Bleistivt',
    'AuthorUrl' => 'http://bleistivt.net',
    'License' => 'GNU GPL2'
);

class YagaUnawardBadgePlugin extends Gdn_Plugin {

    public function profileController_unawardBadges_create($sender, $userID, $userName = '') {
        $sender->permission('Yaga.Badges.Add');

        if (!Gdn::usermodel()->getID($userID)) {
            throw notFoundException('User');
        }

        $sender->getUserInfo($userID, $userName);
        $sender->setData('Badges', Yaga::badgeAwardModel()->getByUser($userID));
        $sender->setData('UserID', $userID);
        $sender->title(t('Unaward Badges'));

        $sender->render('unaward', '', 'plugins/YagaUnawardBadge');
    }


    public function badgeController_unaward_create($sender, $badgeAwardID) {
        $sender->permission('Yaga.Badges.Add');

        if (!$badgeAward = Yaga::badgeAwardModel()->getID($badgeAwardID)) {
            throw notFoundException('BadgeAward');
        }
        $badge = Yaga::badgeModel()->getID($badgeAward->BadgeID);

        $sender->setData('Badgename', $badge->Name);
        $sender->setData('Username', Gdn::usermodel()->getID($badgeAward->UserID)->Name);

        if ($sender->Form->authenticatedPostBack()) {
            Gdn::sql()->delete('BadgeAward', array('BadgeAwardID' => $badgeAwardID), 1);
            Gdn::sql()
                ->update('User')
                ->set('CountBadges', 'CountBadges - 1', false)
                ->where('UserID', $badgeAward->UserID)
                ->put();
            if ($badge) {
                Yaga::givePoints($badgeAward->UserID, -1 * $badge->AwardValue, 'Badge');
            }
            $sender->informMessage(t('The badge was successfully removed from this user.'));
            $sender->jsonTarget('#BadgeAward-'.$badgeAwardID, '', 'Remove');
        }
        $sender->title(t('Unaward Badge'));
        $sender->render('delete', '', 'plugins/YagaUnawardBadge');
    }


    public function profileController_beforeProfileOptions_handler($sender, &$args) {
        if (!c('Yaga.Badges.Enabled') || !checkPermission('Yaga.Badges.Add')) {
            return;
        }
        $args['ProfileOptions'][] = array(
            'Text' => sprite('SpAdminActivities SpNoBadge').' '.t('Unaward Badges'),
            'Url' => '/profile/unawardbadges/'.$sender->User->UserID.'/'.Gdn_Format::url($sender->User->Name)
        );
    }

}
