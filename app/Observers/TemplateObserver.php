<?php

namespace App\Observers;

use App\Models\Template;
use Illuminate\Support\Str;

class TemplateObserver
{
    public function saving(Template $template)
    {
        $template->slug = Str::slug($template->name, '-');
    }
}
