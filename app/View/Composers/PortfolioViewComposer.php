<?php

namespace App\View\Composers;

use App\Portfolio\PortfolioPresentation;
use Illuminate\View\View;

final class PortfolioViewComposer
{
    public function compose(View $view): void
    {
        $view->with('portfolio', PortfolioPresentation::snapshot());
    }
}
