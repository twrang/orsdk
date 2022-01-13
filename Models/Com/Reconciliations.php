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
 * Date: 20-09-2019
 * Time: 07:09
 * Path: /secure/com/reconciliations/Reconciliations.php
 */

namespace OrSdk\Models\Com\Reconciliations;

use OrSdk\Util\dataType;
use OrSdk\Util\BasicEnum;

use OrSdk\Models\BaseModels;


class Reconciliations extends BaseModels
{
    public $id;
    public $documentsId;
    public $amount;
    public $contraDocumentsId;
    public $entryDate;
}

class ReconciliationsTypes extends BasicEnum
{
    const id               	= dataType::INT;
    const documentsId      	= dataType::INT;
    const amount           	= dataType::DECIMAL;
    const contraDocumentsId	= dataType::INT;
    const entryDate        	= dataType::DATE;
}