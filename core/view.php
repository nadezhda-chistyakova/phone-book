<?php

class View
{
	public function render($templateView, $contentView, $data) {
		include 'views/'.$templateView;
	}
}
