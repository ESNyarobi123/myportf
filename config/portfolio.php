<?php

$brandName = env('APP_NAME', 'ERICKsky');

if (in_array($brandName, ['Laravel', 'My Portfolio'], true)) {
    $brandName = 'ERICKsky';
}

return [
    'brand' => [
        'name' => $brandName,
        'nickname' => 'ERICKsky',
        'role' => 'Full-Stack Software Developer',
        'hero_stack_pill' => 'Laravel · Node · React · APIs · more',
        'headline' => 'Full-stack web apps and software — Laravel, Node, mobile, automations, and infrastructure.',
        'summary' => 'Websites and systems using Laravel and other stacks when they fit; Android & iOS; automations with bots and assistants; networking (VPN, proxy) and Linux or Windows servers.',
        'positioning' => 'Full-stack development: Laravel backends, web and mobile apps, automations and AI agents, and hands-on network and server operations.',
        'availability' => 'Available for freelance and contract work.',
        'hero_focus' => [
            'Web & systems',
            'Mobile & automations',
            'Networks & servers',
        ],
    ],

    'metrics' => [
        ['value' => 'Full-stack', 'label' => 'Web & systems'],
        ['value' => 'Mobile', 'label' => 'Android & iOS'],
        ['value' => 'Infra', 'label' => 'Networks & VPS'],
    ],

    'preview_cards' => [
        ['title' => 'Clean backend structure', 'icon' => 'database-24'],
        ['title' => 'Modern UI with Livewire', 'icon' => 'phone-laptop-24'],
        ['title' => 'Useful product thinking', 'icon' => 'design-ideas-24'],
    ],

    'projects' => [
        [
            'slug' => 'ops-control-center',
            'eyebrow' => 'Internal platform',
            'title' => 'Ops Control Center',
            'headline' => 'An operations system that turned scattered tasks into one reliable execution workspace.',
            'summary' => 'A unified operations workspace for approvals, reporting, and daily execution where several disconnected tools used to slow the team down.',
            'result' => 'Created one calm source of truth and made repetitive operational workflows much easier to manage.',
            'metric' => '4 teams unified',
            'icon' => 'apps-24',
            'year' => '2025',
            'client' => 'Operations and admin teams',
            'challenge' => 'The team was using spreadsheets, chats, and separate tools just to manage daily work.',
            'approach' => 'I built one Laravel system for approvals, reporting, and internal workflows with clearer roles and cleaner visibility.',
            'impact_points' => [
                'One place for approvals, reporting, and operations.',
                'Less context switching for the team.',
                'A cleaner system foundation for future growth.',
            ],
            'deliverables' => ['Workflow mapping', 'Admin architecture', 'Role-based dashboards', 'Queues and background processing'],
            'stack' => ['Laravel 13', 'Livewire 4', 'Flux UI', 'Queues'],
        ],
        [
            'slug' => 'service-marketplace',
            'eyebrow' => 'Client-facing product',
            'title' => 'Service Marketplace',
            'headline' => 'A marketplace experience built to turn search, trust, and service discovery into stronger lead flow.',
            'summary' => 'A modern booking and vendor discovery experience focused on trust, clear actions, and a smooth journey from search to conversion.',
            'result' => 'Balanced backend complexity with a frontend flow that felt fast, warm, and conversion-minded.',
            'metric' => 'Better lead flow',
            'icon' => 'people-chat-24',
            'year' => '2024',
            'client' => 'Multi-vendor service business',
            'challenge' => 'Users needed an easy path from browsing to booking without confusion.',
            'approach' => 'I simplified the journey, then connected it to vendor rules, notifications, and backend flows.',
            'impact_points' => [
                'Clearer service discovery and next actions.',
                'Better lead handling for the business.',
                'Balanced product UI with backend complexity.',
            ],
            'deliverables' => ['Marketplace UX', 'Lead and booking flows', 'Notifications', 'Responsive product interface'],
            'stack' => ['Laravel', 'Payments', 'Notifications', 'Responsive UI'],
        ],
        [
            'slug' => 'growth-insight-hub',
            'eyebrow' => 'Data-rich dashboard',
            'title' => 'Growth Insight Hub',
            'headline' => 'A reporting dashboard designed to turn scattered business data into weekly decision-making clarity.',
            'summary' => 'A reporting dashboard built to turn noisy business data into visuals and decisions teams could actually use every week.',
            'result' => 'Turned scattered numbers into a cleaner decision-making rhythm for founders and operators.',
            'metric' => 'Faster reporting',
            'icon' => 'data-trending-24',
            'year' => '2025',
            'client' => 'Founders and growth operators',
            'challenge' => 'Reporting depended on manual work and data was spread across sources.',
            'approach' => 'I turned the dashboard into a decision tool with clearer metrics, views, and permissions.',
            'impact_points' => [
                'Reporting became faster to review.',
                'Less manual work every week.',
                'Teams could act on numbers more quickly.',
            ],
            'deliverables' => ['Data visualization planning', 'Reporting UX', 'Permission-aware dashboards', 'API-backed insights'],
            'stack' => ['Analytics', 'APIs', 'Role-based access', 'Charts-ready'],
        ],
    ],

    'archive_projects' => [
        ['title' => 'Inventory and Billing Suite', 'type' => 'Operations', 'icon' => 'building-store-24'],
        ['title' => 'School or Training Portal', 'type' => 'Education', 'icon' => 'book-database-24'],
        ['title' => 'Client Booking Flow', 'type' => 'Service Product', 'icon' => 'calendar-data-bar-24'],
        ['title' => 'WhatsApp Business Automation', 'type' => 'Automation', 'icon' => 'bot-sparkle-24'],
    ],

    'capabilities' => [
        [
            'title' => 'Backend Systems',
            'description' => 'Laravel systems with clear structure, permissions, integrations, and maintainable logic.',
            'icon' => 'database-24',
            'items' => ['Auth, roles, and business rules', 'Queues, jobs, and external APIs', 'Stable code structure that teams can extend'],
        ],
        [
            'title' => 'Modern Product UI',
            'description' => 'Responsive interfaces that feel clean, modern, and easy to use.',
            'icon' => 'design-ideas-24',
            'items' => ['Livewire 4 experiences with server-driven state', 'Flux UI patterns adapted to a branded visual identity', 'Responsive layouts tuned for desktop and mobile'],
        ],
        [
            'title' => 'Delivery Mindset',
            'description' => 'I care about shipping solid work that actually helps the client or business.',
            'icon' => 'briefcase-24',
            'items' => ['Product thinking before code volume', 'Readable implementation with room to scale', 'A clear path from idea to launch'],
        ],
    ],

    'services' => [
        [
            'title' => 'Custom Web Systems',
            'description' => 'Business tools, portals, and custom systems built around real workflows.',
            'icon' => 'apps-24',
        ],
        [
            'title' => 'Admin Dashboards',
            'description' => 'Dashboards with reports, roles, permissions, and daily controls.',
            'icon' => 'data-trending-24',
        ],
        [
            'title' => 'Business Automation',
            'description' => 'Automation for notifications, approvals, jobs, and repetitive tasks.',
            'icon' => 'arrow-clockwise-dashes-settings-24',
        ],
        [
            'title' => 'Payments and APIs',
            'description' => 'Payments, third-party integrations, and API-driven product features.',
            'icon' => 'link-multiple-24',
        ],
        [
            'title' => 'UI and UX Modernization',
            'description' => 'Refreshing older products into cleaner and smarter experiences.',
            'icon' => 'design-ideas-24',
        ],
        [
            'title' => 'Business Sites and Portfolios',
            'description' => 'Personal, company, and marketing websites with strong presentation.',
            'icon' => 'globe-24',
        ],
    ],

    'workflow' => [
        [
            'title' => 'Understand',
            'description' => 'I start with the real problem and the goal of the product.',
            'icon' => 'search-sparkle-24',
        ],
        [
            'title' => 'Plan',
            'description' => 'I shape the flow, structure, and scope before building deeply.',
            'icon' => 'design-ideas-24',
        ],
        [
            'title' => 'Build',
            'description' => 'I focus on clean code, solid structure, and polished UI.',
            'icon' => 'code-block-24',
        ],
        [
            'title' => 'Launch',
            'description' => 'I finish with testing, polish, and a product ready to use.',
            'icon' => 'arrow-trending-lines-24',
        ],
    ],

    'proof_points' => [
        [
            'label' => 'Clean structure',
            'value' => 'I like systems that stay readable and easy to extend.',
        ],
        [
            'label' => 'Clear communication',
            'value' => 'I keep the work practical, direct, and easy to follow.',
        ],
        [
            'label' => 'Real outcomes',
            'value' => 'I care about useful software, not just nice screenshots.',
        ],
    ],

    'about_highlights' => [
        [
            'title' => 'Backend and logic',
            'description' => 'I enjoy building the logic, architecture, and structure behind products.',
            'icon' => 'person-heart-24',
        ],
        [
            'title' => 'Frontend and UX',
            'description' => 'I also care about interfaces being clean, modern, and easy to use.',
            'icon' => 'shield-checkmark-24',
        ],
        [
            'title' => 'Shipping mindset',
            'description' => 'I like turning ideas into working products that can actually be used.',
            'icon' => 'people-team-24',
        ],
    ],

    'contact_channels' => [
        [
            'label' => 'Email',
            'value' => 'hello@yourdomain.com',
            'href' => 'mailto:hello@yourdomain.com',
            'icon' => 'mail-24',
            'note' => 'Best for project and work inquiries.',
        ],
        [
            'label' => 'WhatsApp',
            'value' => '+255 700 000 000',
            'href' => 'https://wa.me/255700000000',
            'icon' => 'chat-24',
            'note' => 'Good for quick and direct conversations.',
        ],
        [
            'label' => 'LinkedIn',
            'value' => 'linkedin.com/in/your-profile',
            'href' => 'https://www.linkedin.com/in/your-profile',
            'icon' => 'person-feedback-24',
            'note' => 'For professional profile and networking.',
        ],
    ],

    'availability' => [
        'headline' => 'Open for freelance and contract work.',
        'summary' => 'If you need a website, dashboard, business system, or API-based product, feel free to reach out.',
        'notes' => [
            'Usually replies fast.',
            'Works with teams and founders.',
            'Remote-friendly.',
        ],
    ],

    'stack' => ['Laravel 13', 'Livewire 4', 'Flux UI 2', 'Tailwind CSS 4', 'REST APIs', 'Queues', 'Payments', 'Product UX'],
];
