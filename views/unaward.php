<?php if (!defined('APPLICATION')) exit(); 

echo wrap($this->data('Title'), 'h1');
echo '<div id="Badges" class="Box Badges">';
echo '<div class="DismissMessage InfoMessage">'.t('Click on the badge you want to take away from this user.').'</div>';
echo '<div class="PhotoGrid">';
echo wrap(sprintf(t('Badges of %s'), userAnchor(Gdn::userModel()->getID($this->data('UserID')))), 'h4');
foreach($this->data('Badges') as $badge) {
    echo anchor(
        img(
            $badge['Photo'],
            array('class' => 'ProfilePhoto')
        ),
        'yaga/badge/unaward/'.$badge['BadgeAwardID'],
        array('title' => $badge['Name'], 'class' => 'Popup', 'id' => 'BadgeAward-'.$badge['BadgeAwardID'])
    );
}
echo '</div>';
echo '</div>';
