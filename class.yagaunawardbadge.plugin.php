<?php

class YagaUnawardBadgePlugin extends Gdn_Plugin {

    public function profileController_unawardBadges_create($sender, $userID, $userName = '') {
        $sender->permission('Yaga.Badges.Add');

        if (!Gdn::usermodel()->getID($userID)) {
            throw notFoundException('User');
        }

        $sender->getUserInfo($userID, $userName);
        $sender->setData('Badges', Gdn::getContainer()->get(BadgeAwardModel::class)->getByUser($userID));
        $sender->setData('UserID', $userID);
        $sender->title(Gdn::translate('YagaUnawardBadge.UnawardBadges'));

        $sender->render('unaward', '', 'plugins/YagaUnawardBadge');
    }


    public function badgeController_unaward_create($sender, $badgeAwardID) {
        $sender->permission('Yaga.Badges.Add');

        $badgeAward = $sender->BadgeAwardModel->getID($badgeAwardID);
        if (!$badgeAward) {
            throw notFoundException('BadgeAward');
        }

        $badge = $sender->BadgeModel->getID($badgeAward->BadgeID);

        $sender->setData('Badgename', $badge->Name);
        $sender->setData('Username', Gdn::usermodel()->getID($badgeAward->UserID)->Name);

        if ($sender->Form->authenticatedPostBack()) {
            $sender->BadgeAwardModel->deleteID($badgeAwardID);

            Gdn::sql()
                ->update('User')
                ->set('CountBadges', 'CountBadges - 1', false)
                ->where('UserID', $badgeAward->UserID)
                ->put();

            if ($badge) {
                UserModel::givePoints($badgeAward->UserID, -1 * $badge->AwardValue, 'Badge');
            }

            $sender->informMessage(Gdn::translate('YagaUnawardBadge.Success'));
            $sender->jsonTarget('#BadgeAward-'.$badgeAwardID, '', 'Remove');
        }

        $sender->title(Gdn::translate('YagaUnawardBadge.UnawardBadge'));
        $sender->render('delete', '', 'plugins/YagaUnawardBadge');
    }


    public function profileController_beforeProfileOptions_handler($sender) {
        $args = &$sender->EventArguments;

        if (!Gdn::config('Yaga.Badges.Enabled') || !checkPermission('Yaga.Badges.Add')) {
            return;
        }

        $args['ProfileOptions'][] = [
            'Text' => sprite('SpAdminActivities SpNoBadge').' '.Gdn::translate('YagaUnawardBadge.UnawardBadges'),
            'Url' => '/profile/unawardbadges/'.$sender->User->UserID.'/'.Gdn_Format::url($sender->User->Name)
        ];
    }

}
