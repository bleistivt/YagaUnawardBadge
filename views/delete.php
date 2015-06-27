<?php if (!defined('APPLICATION')) exit(); 

echo wrap($this->data('Title'), 'h1');
echo $this->Form->open();
echo $this->Form->errors();
echo '<div class="P">'.sprintf(
    T('Are you sure you want to take away <em style="font-style:italic;">%s</em> from %s? If the the conditions for receiving this badge are still met, it will be awarded again.'),
    $this->data('Badgename'),
    $this->data('Username')
).'</div>';
echo '<div class="Buttons Buttons-Confirm">';
echo $this->Form->button('OK', array('class' => 'Button Primary'));
echo $this->Form->button('Cancel', array('type' => 'button', 'class' => 'Button Close'));
echo '</div>';
echo $this->Form->close();
