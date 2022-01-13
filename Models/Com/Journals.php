<?php
/**
 * Copyright (c) 2021. Fakturaservice A/S - All Rights Reserved 
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Proprietary and confidential
 * Written by Torben Wrang Laursen <twl@fakturaservice.dk>, February 2021
 */

/**
 * Generated by GenerateModel.php script.
 * User: twl
 * Date: 24-09-2020
 * Time: 01:09
 * Path: /secure/com/journals/Journals.php
 */

namespace OrSdk\Models\Com\Journals;

use OrSdk\Util\dataType;
use OrSdk\Util\BasicEnum;

use OrSdk\Models\BaseModels;

class Journals extends BaseModels
{
    public $id;
    public $name;
    public $type;
}

class JournalsTypes extends BasicEnum
{
    const id  	= dataType::INT;
    const name	= dataType::VARCHAR;
    const type	= dataType::ENUM;
}

abstract class Type extends BasicEnum
{
    const standard   	= 'standard';
    const import     	= 'import';
    const backconnect	= 'backconnect';
    const bankfile   	= 'bankfile';
}