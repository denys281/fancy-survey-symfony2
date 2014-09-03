<?php

namespace Megogo\CoreBundle;

/**
 * Contains all events thrown in the MegogoCoreBundle
 *
 * @package Megogo\CoreBundle
 */
final class MegogoCoreEvents
{
    /**
     * The PRE_STEP_ONE event occurs before step one.
     *
     * This event allows you to make some operations before it.
     */
    const PRE_STEP_ONE = 'megogo_core.pre_step_one';

    /**
     * The PRE_STEP_TWO event occurs before step two
     *
     * This event allows you to make some operations before it.
     */
    const PRE_STEP_TWO = 'megogo_core.pre_step_two';

    /**
     * The PRE_STEP_THREE event occurs before step three
     *
     * This event allows you to make some operations before it.
     */
    const PRE_STEP_THREE = 'megogo_core.pre_step_three';

}
