<?php namespace JBR\AnsiHelper\Container;

/************************************************************************************
 * Copyright (c) 2016, Jan Runte
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions  of source code must retain the above copyright notice,  this
 * list of conditions and the following disclaimer.
 *
 * 2. Redistributions  in  binary  form  must  reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * THIS  SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY  EXPRESS OR IMPLIED WARRANTIES,  INCLUDING, BUT NOT LIMITED TO, THE  IMPLIED
 * WARRANTIES  OF  MERCHANTABILITY  AND   FITNESS  FOR  A  PARTICULAR  PURPOSE  ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL  DAMAGES
 * (INCLUDING,  BUT  NOT LIMITED TO,  PROCUREMENT OF SUBSTITUTE GOODS  OR  SERVICES;
 * LOSS  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND  ON
 * ANY  THEORY  OF  LIABILITY,  WHETHER  IN  CONTRACT,  STRICT  LIABILITY,  OR TORT
 * (INCLUDING  NEGLIGENCE OR OTHERWISE)  ARISING IN ANY WAY OUT OF THE USE OF  THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ************************************************************************************/

/**
 *
 */
interface Sequence
{

    const ESCAPE = "\033";

    const CURSOR_POSITION = '[%u;%uH';

    const CURSOR_POSITION_COLUMN = '[%u;H';

    const CURSOR_POSITION_ROW = '[;%uH';

    const CURSOR_POSITION_HOME = '[H';

    const CURSOR_POSITION_FORCE = '[%u;%uf';

    const CURSOR_UP = '[%uA';

    const CURSOR_DOWN = '[%uB';

    const CURSOR_FORWARD = '[%uC';

    const CURSOR_BACKWARD = '[%uD';

    const CURSOR_NEXT_LINE = '[%uE';

    const CURSOR_PREVIOUS_LINE = '[%uF';

    const CURSOR_SAVE_POSITION = '[s';

    const CURSOR_RESTORE_POSITION = '[u';

    const CURSOR_ALTERNATE_SAVE_POSITION = '7';

    const CURSOR_ALTERNATE_RESTORE_POSITION = '8';

    const CURSOR_HIDE = '[?25l';

    const CURSOR_SHOW = '[?25h';

    const ERASE_SCREEN_BOTTOM = '[J';

    const ERASE_SCREEN_TOP = '[1J';

    const ERASE_SCREEN = '[2J';

    const ERASE_END_OF_LINE = '[K';

    const ERASE_START_OF_LINE = '[1K';

    const ERASE_LINE = '[2K';

    const PRINT_SCREEN = '[i';

    const PRINT_LINE = '[1i';

    const PRINT_START_LOG = '[4i';

    const PRINT_STOP_LOG = '[5i';

    const SCROLL_ENABLE = '[r';

    const SCROLL_SCREEN = '[%u;%ur';

    const SCROLL_DOWN = 'D';

    const SCROLL_UP = 'M';

    const TAB_SET = 'H';

    const TAB_CLEAR_ON_LINE = '[g';

    const TAB_CLEAR_ALL = '[3g';

    const KEY_SET = '[%s;"%s"p';

    const ATTRIBUTE_RENDITION_SET = '[%u;%um';

    const ATTRIBUTE_MODES_SET = '[%sm';

    const ATTRIBUTE_MODES_RESET = '[m';

    const RESET_DEVICE = 'c';
}