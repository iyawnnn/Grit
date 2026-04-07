<?php

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class CustomPolicy implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::IMG, [
                Keyword::SELF,
                'res.cloudinary.com',
                '*.googleusercontent.com',
                'data:',
            ])
            ->add(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'fonts.googleapis.com',
                'fonts.bunny.net',
                'unpkg.com', // Added for Trix Editor CSS
            ])
            ->add(Directive::FONT, [
                Keyword::SELF,
                'fonts.gstatic.com',
                'fonts.bunny.net', 
                'data:',
            ])
            ->add(Directive::SCRIPT, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                Keyword::UNSAFE_EVAL,
                'unpkg.com', // Added for Trix Editor JS
                // 'cdn.jsdelivr.net', // Uncomment if your chart uses jsdelivr
            ])
            ->add(Directive::FRAME, [
                Keyword::SELF,
                'res.cloudinary.com',
            ])
            ->add(Directive::OBJECT, [
                Keyword::SELF,
                'res.cloudinary.com',
            ]);
    }
}