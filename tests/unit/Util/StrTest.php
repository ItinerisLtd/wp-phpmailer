<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Util;

use Codeception\Test\Unit;

class StrTest extends Unit
{
    public function testScreamingSnake()
    {
        $providers = [
            ['abc', 'ABC'],
            ['d-e-f', 'D_E_F'],
            ['gh i', 'GH_I'],
            ['j_k_l', 'J_K_L'],
            ['mno_pqr_stu', 'MNO_PQR_STU'],
            ['VW_XYZ', 'VW_XYZ'],
        ];

        foreach($providers as $provider) {
            $this->assertSame(
                $provider[1],
                Str::screamingSnake($provider[0])
            );
        }
    }

    public function testSnake()
    {
        $providers = [
            ['abc', 'abc'],
            ['d-e-f', 'd_e_f'],
            ['gh i', 'gh_i'],
            ['j_k_l', 'j_k_l'],
            ['mno_pqr_stu', 'mno_pqr_stu'],
            ['VW_XYZ', 'vw_xyz'],
        ];

        foreach($providers as $provider) {
            $this->assertSame(
                $provider[1],
                Str::snake($provider[0])
            );
        }
    }
}
