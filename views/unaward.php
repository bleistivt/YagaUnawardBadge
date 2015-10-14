<?php if (!defined('APPLICATION')) exit(); 

echo wrap($this->title(), 'h1');
?>

<div id="Badges" class="Box Badges">
<div class="DismissMessage InfoMessage">
    <?php echo t('Click on the badge you want to take away from this user.'); ?>
</div>

<div class="PhotoGrid">
<?php

echo wrap(sprintf(
    t('Badges of %s'),
    userAnchor(Gdn::userModel()->getID($this->data('UserID')))
), 'h4');

foreach($this->data('Badges') as $badge) {
    echo anchor(
        img($badge['Photo'], ['class' => 'ProfilePhoto']),
        'yaga/badge/unaward/'.$badge['BadgeAwardID'],
        [
            'title' => $badge['Name'],
            'class' => 'Popup',
            'id' => 'BadgeAward-'.$badge['BadgeAwardID']
        ]
    );
}
?>

</div>
</div>
