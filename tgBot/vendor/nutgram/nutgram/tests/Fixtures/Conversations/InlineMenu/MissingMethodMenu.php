<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class MissingMethodMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText('Choose a color:')
            ->addButtonRow(InlineKeyboardButton::make('Red', callback_data: 'red@handleColor'))
            ->addButtonRow(InlineKeyboardButton::make('Green', callback_data: 'green@handleColor'))
            ->addButtonRow(InlineKeyboardButton::make('Yellow', callback_data: 'yellow@handleMissing'))
            ->orNext('none')
            ->showMenu();
    }

    public function handleColor(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: $color!")->showMenu();
    }

    public function none(Nutgram $bot)
    {
        $bot->sendMessage('Bye!');
        $this->end();
    }
}
