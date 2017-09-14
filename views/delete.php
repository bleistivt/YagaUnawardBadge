<?php if (!defined('APPLICATION')) exit(); 

$this->Form->setStyles('legacy');

echo wrap($this->title(), 'h1'),

    $this->Form->open(),
    $this->Form->errors(),

    '<div class="P">',
    sprintf(
        T('Are you sure you want to take away <em style="font-style:italic;">%s</em> from %s? If the the conditions for receiving this badge are still met, it will be awarded again.'),
        $this->data('Badgename'),
        $this->data('Username')
    ),
    '</div>',

    '<div class="Buttons Buttons-Confirm">',
    $this->Form->button('OK', ['class' => 'Button Primary']),
    $this->Form->button('Cancel', ['type' => 'button', 'class' => 'Button Close']),
    '</div>',

    $this->Form->close();
