<?php if (!defined('APPLICATION')) exit(); 

$this->Form->setStyles('legacy');

echo wrap($this->title(), 'h1'),

    $this->Form->open(),
    $this->Form->errors(),

    '<div class="P">',
    sprintf(
        Gdn::translate('YagaUnawardBadge.Confirm'),
        $this->data('Badgename'),
        $this->data('Username')
    ),
    '</div>',

    '<div class="Buttons Buttons-Confirm">',
    $this->Form->button('OK', ['class' => 'Button Primary']),
    $this->Form->button('Cancel', ['type' => 'button', 'class' => 'Button Close']),
    '</div>',

    $this->Form->close();
