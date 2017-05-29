<?php

require_once('vendor/autoload.php');
$climate = new League\CLImate\CLImate;
$climate->red()->out('This prints to the terminal.');

$climate->backgroundRed()->white()->inline('Waiting');

for ($i = 0; $i < 10; $i++) {
    $climate->blue()->inline('.');
}

$climate->out('');

$climate->underline()->out('I have a line beneath me.');

$climate->blink()->dim('Dim. But noticeable.');

// 下面两者等价，顺序可以打乱
// $climate->backgroundBlue()->underline()->green()->blink()->out('This may be a little hard to read.');
$climate->backgroundBlueBlinkGreenUnderline('This may be a little hard to read.');

$climate->blue('Please <light_red>remember</light_red> to restart the server.');

$climate->blue('Please <bold><background_light_red>remember</background_light_red></bold> to restart the server.');

$climate->error('Ruh roh.');
$climate->comment('Just so you know.');
$climate->whisper('Not so important, just a heads up.');
$climate->shout('This. This is important.');
$climate->info('Nothing fancy here. Just some info.');

$climate->style->addColor('lilac', 35);
$climate->lilac('What a pretty color.');
$climate->backgroundLilac()->out('This background is a pretty color.');
$climate->out('Just this <lilac>word</lilac> is a pretty color.');
$climate->out('Just this <background_lilac>word</background_lilac> is a pretty color.');

$climate->style->addCommand('error', 'light_blue');
$climate->error('Whelp. That did not turn out so well.');
