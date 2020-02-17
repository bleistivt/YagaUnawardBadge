<?php if (!defined('APPLICATION')) exit(); 

echo wrap($this->title(), 'h1');
?>

<div id="Badges" class="Box Badges">
<div class="DismissMessage InfoMessage">
    <?php echo Gdn::translate('YagaUnawardBadge.ClickToUnaward'); ?>
</div>

<div class="PhotoGrid">
<?php

echo wrap(sprintf(
    Gdn::translate('YagaUnawardBadge.BadgesOf'),
    userAnchor(Gdn::userModel()->getID($this->data('UserID')))
), 'h4');

foreach($this->data('Badges') as $badge) {
    echo anchor(
        img($badge['Photo'], ['class' => 'ProfilePhoto']),
        'badge/unaward/'.$badge['BadgeAwardID'],
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
