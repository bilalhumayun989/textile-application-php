<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Textile Tools')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            /* Sidebar Theme Management - Royal Purple Palette (Blended) */
            --sidebar-bg: #eae4ffff; /* Slightly deeper lavender tint for better blending */
            --sidebar-border: #ece7f7;
            --sidebar-shadow: rgba(109, 40, 217, 0.05);
            
            /* Sidebar Heading Management */
            --sidebar-header-color: #6d28d9; /* Deep, rich Royal Purple */
            --sidebar-header-size: 1.4rem;
            --sidebar-header-mt: 2.5rem;
            
            --sidebar-link: #000; /* Solid Black text */
            --sidebar-link-hover-bg: #f5f3ff;
            --sidebar-link-hover-text: #7c3aed;
            
            --sidebar-active-bg: #7c3aed; /* Vibrant Royal Purple */
            --sidebar-active-text: #ffffff;
            --sidebar-active-shadow: rgba(124, 58, 237, 0.2);
            
            --sidebar-sub-link: #333; /* Darker sub-links for contrast */
            --sidebar-sub-active-bg: #f3f0f7;
            
            --sidebar-icon: #000; /* Solid Black icons */
            --sidebar-main-content-bg: #f7f4ff; /* Slightly richer purple tint for blending */

            /* Global Theme Variables */
            --primary-purple: #7c3aed;
            --primary-purple-hover: #6d28d9;
            --primary-purple-soft: #f5f3ff;
            --text-dark: #1f2937;
            --border-soft: #e5e7eb;
            --card-radius: 20px;
            --btn-radius: 12px;
        }

        body, html {
            height: 100%;
            margin: 0;
            background-color: var(--sidebar-main-content-bg);
            color: var(--text-dark);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        /* Global Theme Overrides */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-dark);
            font-weight: 700 !important;
        }

        .btn-primary {
            background-color: var(--primary-purple) !important;
            border-color: var(--primary-purple) !important;
            border-radius: var(--btn-radius) !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.15) !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-purple-hover) !important;
            border-color: var(--primary-purple-hover) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.2) !important;
        }

        .btn-outline-primary {
            color: var(--primary-purple) !important;
            border-color: var(--primary-purple) !important;
            border-radius: var(--btn-radius) !important;
            font-weight: 600 !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-purple) !important;
            color: #fff !important;
        }

        /* Success & Danger Tweak - Custom Purple Success */
        .alert-success, .bg-success {
            background-color: #f5f3ff !important; /* Beautiful Light Purple */
            color: #6d28d9 !important; /* Deep Purple Text */
            border: 1px solid #ddd6fe !important; /* Soft Purple Border */
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.08) !important;
        }

        .toast.bg-success {
            background-color: #f5f3ff !important;
            color: #6d28d9 !important;
            border: 1px solid #ddd6fe !important;
        }

        .toast.bg-success .btn-close {
            filter: invert(0.2) sepia(1) saturate(5) hue-rotate(240deg); /* Purple-ish close button */
        }

        .btn-danger, .bg-danger {
            background-color: #ef4444 !important; /* Premium Rose/Red */
            border-color: #ef4444 !important;
        }

        .text-primary { color: var(--primary-purple) !important; }
        .text-success { color: #7c3aed !important; } /* Use Purple for success text indicators too */
        .text-danger { color: #dc2626 !important; }
        .text-info { color: #2563eb !important; }

        /* Background Utilities */
        .bg-primary-subtle {
            background-color: var(--primary-purple-soft) !important;
            color: var(--primary-purple) !important;
        }

        .bg-light {
            background-color: #f9fafb !important;
            border: 1px solid var(--sidebar-border) !important;
        }

        /* Card Customization */
        .card {
            background-color: #ffffff !important;
            border: 1px solid var(--sidebar-border) !important;
            border-radius: var(--card-radius) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(124, 58, 237, 0.06) !important;
        }

        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid var(--sidebar-border) !important;
            padding: 1.25rem 1.5rem !important;
            font-weight: 700 !important;
            color: var(--sidebar-header-color) !important;
        }

        /* Table Style */
        .table thead th {
            background-color: #f8f9fa !important;
            border-bottom: 2px solid var(--sidebar-border) !important;
            color: var(--text-dark) !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(124, 58, 237, 0.02) !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(124, 58, 237, 0.04) !important;
        }

        /* Badge Customization */
        .badge {
            border-radius: 6px !important;
            padding: 0.4em 0.6em !important;
            font-weight: 600 !important;
        }

        .badge.bg-primary { background-color: var(--primary-purple) !important; }
        .badge.bg-info { background-color: #3b82f6 !important; }

        /* Accordion Customization */
        .accordion-item {
            border: 1px solid var(--sidebar-border) !important;
            border-radius: 12px !important;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }

        .accordion-button {
            font-weight: 600 !important;
            color: var(--text-dark) !important;
            background-color: #fff !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--primary-purple) !important;
            background-color: var(--primary-purple-soft) !important;
            box-shadow: none !important;
        }

        /* Input Customization */
        .form-control, .form-select {
            border-radius: 10px !important;
            border: 1px solid var(--border-soft) !important;
            padding: 0.65rem 1rem !important;
            transition: all 0.2s ease !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-purple) !important;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1) !important;
        }

        /* Modern Light Sidebar - Master Theme Managed */
        #sidebarMenu {
            height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 25px var(--sidebar-shadow);
            z-index: 1000;
            border-radius: 0 25px 25px 0;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            transition: all 0.3s ease;
        }

        /* ============================================
           SIDEBAR COLLAPSED STATE - CLEAN IMPLEMENTATION
           ============================================ */
        #sidebarMenu.collapsed {
            width: 80px !important;
        }

        /* Hide all text labels, chevrons, hr, header text when collapsed */
        #sidebarMenu.collapsed .sidebar-label,
        #sidebarMenu.collapsed .chevron-icon,
        #sidebarMenu.collapsed .sidebar-header-text,
        #sidebarMenu.collapsed .sidebar-hr {
            display: none !important;
        }

        /* Close all open sub-menus */
        #sidebarMenu.collapsed .collapse {
            display: none !important;
        }

        /* Center each nav-item */
        #sidebarMenu.collapsed #sidebarNav > .nav-item {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 6px 0 !important;
        }

        /* The link itself becomes a centered 48x48 square */
        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link {
            width: 48px !important;
            height: 48px !important;
            min-width: 48px !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            border-radius: 12px !important;
            position: relative !important;
            background: transparent !important;
            overflow: visible !important;
            gap: 0 !important;
        }

        /* Icon perfectly centered */
        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link .sidebar-icon {
            font-size: 1.35rem !important;
            width: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            flex-shrink: 0 !important;
        }

        /* CSS Tooltip using ::after pseudo-element with data-label */
        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link::after {
            content: attr(data-label);
            position: absolute;
            left: 58px;
            top: 50%;
            transform: translateY(-50%);
            background: #1a202c;
            color: #fff;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            border-left: 3px solid #7c3aed;
            transition: opacity 0.15s ease;
        }

        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link:hover::after {
            opacity: 1;
        }

        /* Centered toggle container */
        #sidebarMenu.collapsed .sidebar-toggle-container {
            justify-content: center !important;
            padding: 1.5rem 0 !important;
            margin: 0 !important;
        }

        /* Main content shifts left when sidebar collapsed */
        main.collapsed {
            margin-left: 80px !important;
        }

        /* Toggle button styles */
        #sidebarDesktopToggle {
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(124, 58, 237, 0.1);
            color: var(--primary-purple);
            border: 1px solid rgba(124, 58, 237, 0.2);
            transition: all 0.2s;
            flex-shrink: 0;
        }

        #sidebarDesktopToggle:hover {
            background: rgba(124, 58, 237, 0.1);
            transform: scale(1.05);
            color: var(--primary-purple-hover);
        }

        #sidebarMenu::-webkit-scrollbar {
            display: none;
        }

        .sidebar-content {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            padding-bottom: 1.5rem;
        }

        /* Normal nav-link style using flex for icon + text */
        #sidebarMenu .sidebar-link {
            display: flex !important;
            align-items: center;
            gap: 10px;
        }

        #sidebarMenu .sidebar-link .sidebar-icon {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        #sidebarMenu .nav-link {
            color: var(--sidebar-link);
            font-weight: 500;
            padding: 0.8rem 1.25rem;
            margin: 0.4rem 15px;
            border-radius: 15px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebarMenu .nav-link i {
            color: var(--sidebar-icon) !important;
            width: 22px;
            text-align: center;
            font-size: 1.05rem;
        }

        #sidebarMenu .nav-link:hover,
        #sidebarMenu .nav-link[aria-expanded="true"] {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-link-hover-text);
            transform: scale(1.02);
        }

        #sidebarMenu .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
            font-weight: 600;
            box-shadow: 0 4px 12px var(--sidebar-active-shadow);
        }

        /* Active state — white icon so it's readable on dark purple bg */
        #sidebarMenu .nav-link.active .sidebar-icon,
        #sidebarMenu .nav-link.active i {
            color: #ffffff !important;
        }

        /* Collapsed sidebar: active icon gets the same dark purple bg + white icon */
        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link.active {
            background-color: var(--sidebar-active-bg) !important;
            box-shadow: 0 4px 12px var(--sidebar-active-shadow) !important;
        }

        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link.active .sidebar-icon {
            color: #ffffff !important;
        }

        /* Collapsed active tooltip uses a darker purple background */
        #sidebarMenu.collapsed #sidebarNav > .nav-item > a.sidebar-link.active::after {
            background: #4c1d95 !important;
            border-left-color: #7c3aed !important;
        }

        /* Submenu Styling */
        #sidebarMenu .collapse .nav-link {
            padding: 0.6rem 1rem 0.6rem 3rem;
            font-size: 0.88rem;
            margin: 0.2rem 18px;
            color: var(--sidebar-sub-link);
            background: transparent;
        }

        #sidebarMenu .collapse .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-active-bg); /* Use Purple color for text on light hover */
            transform: translateX(5px);
        }

        #sidebarMenu .collapse .nav-link.active {
            background-color: var(--sidebar-sub-active-bg);
            color: var(--sidebar-active-bg); /* Use Purple color for text on light active sub-item */
            font-weight: 600;
        }

        #sidebarMenu .collapse .nav-link.active i {
            color: var(--sidebar-active-bg) !important; /* Ensure sub-icons are purple, not white */
        }

        /* Chevron Rotation */
        .nav-link .chevron-icon {
            transition: transform 0.3s ease;
            font-size: 0.75rem;
            color: #777;
        }

        .nav-link[aria-expanded="true"] .chevron-icon {
            transform: rotate(180deg);
            color: var(--sidebar-active-text);
        }

        main {
            margin-left: {{ Auth::check() ? '250px' : '0' }};
            padding: 2rem;
            min-height: 100vh;
            background-color: var(--sidebar-main-content-bg);
            transition: all 0.3s ease;
        }

        /* Bottom Delete button in sidebar */
        #sidebarDeleteBtn {
            margin: 0 0;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        #sidebarDeleteBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.15);
        }

        .sidebar-footer {
            padding: 1.5rem 1.25rem;
            border-top: 1px solid #f0f0f0;
            margin-top: auto; /* Push to bottom when screen is tall */
        }

        /* Mobile responsive */
        @media (max-width: 767px) {
            #sidebarMenu {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1030;
            }

            /* Mobile collapsed state - 80px sidebar by default */
            #sidebarMenu.mobile-collapsed {
                transform: translateX(0) !important;
                width: 80px !important;
            }

            /* Mobile expanded state - full sidebar overlay */
            #sidebarMenu.mobile-expanded {
                transform: translateX(0) !important;
                width: 250px !important;
                box-shadow: 0 0 0 10000px rgba(0, 0, 0, 0.5);
            }

            /* Blur overlay for mobile expanded sidebar */
            .mobile-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(3px);
                z-index: 1029;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .mobile-backdrop.show {
                opacity: 1;
                visibility: visible;
            }

            /* Prevent body scroll when sidebar is expanded */
            body.sidebar-mobile-expanded {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }

            /* Hide mobile hamburger menu button completely */
            #sidebarToggle {
                display: none !important;
            }

            /* Show desktop toggle button on mobile too */
            #sidebarDesktopToggle {
                display: flex !important;
            }

            main {
                margin-left: {{ Auth::check() ? '80px' : '0' }}; /* Account for collapsed sidebar */
                padding-top: 1rem;
            }

            /* Adjust sidebar content for mobile collapsed state */
            #sidebarMenu.mobile-collapsed .sidebar-label,
            #sidebarMenu.mobile-collapsed .chevron-icon,
            #sidebarMenu.mobile-collapsed .sidebar-header-text,
            #sidebarMenu.mobile-collapsed .sidebar-hr {
                display: none !important;
            }

            /* Close all open sub-menus in mobile collapsed state */
            #sidebarMenu.mobile-collapsed .collapse {
                display: none !important;
            }

            /* Center each nav-item in mobile collapsed state */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                margin: 6px 0 !important;
            }

            /* The link itself becomes a centered 48x48 square in mobile collapsed state */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link {
                width: 48px !important;
                height: 48px !important;
                min-width: 48px !important;
                padding: 0 !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: center !important;
                border-radius: 12px !important;
                position: relative !important;
                background: transparent !important;
                overflow: visible !important;
                gap: 0 !important;
            }

            /* Icon perfectly centered in mobile collapsed state */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link .sidebar-icon {
                font-size: 1.35rem !important;
                width: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                flex-shrink: 0 !important;
            }

            /* CSS Tooltip using ::after pseudo-element with data-label for mobile collapsed state */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link::after {
                content: attr(data-label);
                position: absolute;
                left: 58px;
                top: 50%;
                transform: translateY(-50%);
                background: #1a202c;
                color: #fff;
                padding: 7px 14px;
                border-radius: 8px;
                font-size: 0.78rem;
                font-weight: 600;
                white-space: nowrap;
                z-index: 99999;
                opacity: 0;
                pointer-events: none;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                border-left: 3px solid #7c3aed;
                transition: opacity 0.15s ease;
            }

            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link:hover::after {
                opacity: 1;
            }

            /* Centered toggle container for mobile collapsed state */
            #sidebarMenu.mobile-collapsed .sidebar-toggle-container {
                justify-content: center !important;
                padding: 1.5rem 0 !important;
                margin: var(--sidebar-header-mt) 0 2rem 0 !important;
            }

            /* Delete button in mobile collapsed state */
            #sidebarMenu.mobile-collapsed .sidebar-footer {
                padding: 1.5rem 0 !important;
                display: flex !important;
                justify-content: center !important;
            }
            #sidebarMenu.mobile-collapsed #sidebarDeleteBtn {
                width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                border-radius: 12px !important;
                justify-content: center !important;
                position: relative;
                overflow: visible !important;
            }
            #sidebarMenu.mobile-collapsed .sidebar-delete-label {
                display: none !important;
            }
            #sidebarMenu.mobile-collapsed #sidebarDeleteBtn::after {
                content: attr(data-label);
                position: absolute;
                left: 52px;
                top: 50%;
                transform: translateY(-50%);
                background: #991b1b;
                color: #fff;
                padding: 7px 14px;
                border-radius: 8px;
                font-size: 0.78rem;
                font-weight: 600;
                white-space: nowrap;
                z-index: 99999;
                opacity: 0;
                pointer-events: none;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                border-left: 3px solid #ef4444;
                transition: opacity 0.15s ease;
            }
            #sidebarMenu.mobile-collapsed #sidebarDeleteBtn:hover::after {
                opacity: 1;
            }

            /* Mobile expanded state - show all content like desktop */
            #sidebarMenu.mobile-expanded .sidebar-label,
            #sidebarMenu.mobile-expanded .chevron-icon,
            #sidebarMenu.mobile-expanded .sidebar-header-text,
            #sidebarMenu.mobile-expanded .sidebar-hr {
                display: block !important;
            }

            /* Reset sub-menus in mobile expanded state - only show if they have 'show' class */
            #sidebarMenu.mobile-expanded .collapse.show {
                display: block !important;
            }

            /* Reset nav-item layout in mobile expanded state */
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item {
                display: block !important;
                justify-content: flex-start !important;
                align-items: center !important;
                margin: 0.4rem 15px !important;
            }

            /* Reset link layout in mobile expanded state */
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link {
                width: auto !important;
                height: auto !important;
                min-width: auto !important;
                padding: 0.8rem 1.25rem !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: row !important;
                justify-content: flex-start !important;
                align-items: center !important;
                border-radius: 15px !important;
                position: relative !important;
                background: transparent !important;
                overflow: visible !important;
                gap: 10px !important;
            }

            /* Reset icon in mobile expanded state */
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link .sidebar-icon {
                font-size: 1.05rem !important;
                width: 20px !important;
                margin: 0 !important;
                padding: 0 !important;
                flex-shrink: 0 !important;
            }

            /* Hide tooltips in mobile expanded state */
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link::after {
                display: none !important;
            }

            /* Mobile active states - comprehensive purple background for ALL menu items */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link.active {
                background-color: var(--sidebar-active-bg) !important;
                color: var(--sidebar-active-text) !important;
                box-shadow: 0 4px 12px var(--sidebar-active-shadow) !important;
                font-weight: 600 !important;
            }

            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link.active .sidebar-icon {
                color: #ffffff !important;
            }

            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link.active::after {
                background: #4c1d95 !important;
                border-left-color: #7c3aed !important;
            }

            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link.active {
                background-color: var(--sidebar-active-bg) !important;
                color: var(--sidebar-active-text) !important;
                font-weight: 600 !important;
                box-shadow: 0 4px 12px var(--sidebar-active-shadow) !important;
            }

            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link.active .sidebar-icon,
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link.active i {
                color: #ffffff !important;
            }

            /* Specific Ledger and Expense active states for mobile */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link[data-bs-toggle="collapse"].active {
                background-color: var(--sidebar-active-bg) !important;
                color: var(--sidebar-active-text) !important;
            }

            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link[data-bs-toggle="collapse"].active {
                background-color: var(--sidebar-active-bg) !important;
                color: var(--sidebar-active-text) !important;
            }

            /* Mobile hover states */
            #sidebarMenu.mobile-collapsed #sidebarNav > .nav-item > a.sidebar-link:hover,
            #sidebarMenu.mobile-expanded #sidebarNav > .nav-item > a.sidebar-link:hover {
                background-color: var(--sidebar-link-hover-bg) !important;
                color: var(--sidebar-link-hover-text) !important;
                transform: scale(1.02) !important;
            }

            /* Mobile submenu active states */
            #sidebarMenu.mobile-expanded .collapse .nav-link.active {
                background-color: var(--sidebar-sub-active-bg) !important;
                color: var(--sidebar-active-bg) !important;
                font-weight: 600 !important;
            }

            #sidebarMenu.mobile-expanded .collapse .nav-link.active i {
                color: var(--sidebar-active-bg) !important;
            }

            /* Mobile chevron rotation - specific rules */
            #sidebarMenu.mobile-expanded .nav-link[aria-expanded="true"] .chevron-icon {
                transform: rotate(180deg) !important;
                color: var(--sidebar-active-text) !important;
            }

            #sidebarMenu.mobile-collapsed .nav-link[aria-expanded="true"] .chevron-icon {
                transform: rotate(180deg) !important;
                color: var(--sidebar-active-text) !important;
            }

            /* Ensure chevron rotation works for both collapsed and expanded mobile states */
            #sidebarMenu.mobile-collapsed .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .chevron-icon,
            #sidebarMenu.mobile-expanded .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .chevron-icon {
                transform: rotate(180deg) !important;
                color: var(--sidebar-active-text) !important;
            }

            /* Default chevron state */
            #sidebarMenu.mobile-collapsed .nav-link[data-bs-toggle="collapse"] .chevron-icon,
            #sidebarMenu.mobile-expanded .nav-link[data-bs-toggle="collapse"] .chevron-icon {
                transform: rotate(0deg) !important;
                color: #777 !important;
            }

            /* Reset toggle container in mobile expanded state */
            #sidebarMenu.mobile-expanded .sidebar-toggle-container {
                justify-content: space-between !important;
                padding: 0 !important;
                margin: var(--sidebar-header-mt) 0 2rem 0 !important;
            }

            /* Reset delete button in mobile expanded state */
            #sidebarMenu.mobile-expanded .sidebar-footer {
                padding: 1.5rem 1.25rem !important;
                display: block !important;
            }
            #sidebarMenu.mobile-expanded #sidebarDeleteBtn {
                width: 100% !important;
                height: auto !important;
                padding: 0.6rem 1.5rem !important;
                border-radius: 12px !important;
                justify-content: center !important;
                position: relative !important;
                overflow: visible !important;
            }
            #sidebarMenu.mobile-expanded .sidebar-delete-label {
                display: inline !important;
            }
            #sidebarMenu.mobile-expanded #sidebarDeleteBtn::after {
                display: none !important;
            }
        }

        /* Logout and Delete button collapsed state */
        #sidebarMenu.collapsed .logout-btn,
        #sidebarMenu.collapsed #sidebarDeleteBtn {
            width: 44px !important;
            height: 44px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 12px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        #sidebarMenu.collapsed .logout-btn::after,
        #sidebarMenu.collapsed #sidebarDeleteBtn::after {
            content: attr(data-label);
            position: absolute;
            left: 52px;
            top: 50%;
            transform: translateY(-50%);
            background: #1a202c;
            color: #fff;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            border-left: 3px solid #ef4444;
            transition: opacity 0.15s ease;
        }
        #sidebarMenu.collapsed .logout-btn:hover::after,
        #sidebarMenu.collapsed #sidebarDeleteBtn:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>

<!-- Toast Notification Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
    <div id="statusToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@auth
<!-- Mobile toggle button -->
<button class="btn btn-primary d-md-none" type="button" id="sidebarToggle" style="position: fixed; top: 1rem; left: 1rem; z-index: 1001;">☰ Menu</button>

<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-md-block">
    <div class="sidebar-content">
        <ul class="nav flex-column mb-auto" id="sidebarNav">
            
            <li class="nav-item px-3 d-flex align-items-center justify-content-between sidebar-toggle-container" style="margin-top: var(--sidebar-header-mt); margin-bottom: 2rem;">
                <h5 class="fw-bold mb-0 sidebar-header-text" style="color: var(--sidebar-header-color); font-size: var(--sidebar-header-size); letter-spacing: 1.5px; text-transform: uppercase;">Textile</h5>
                <div id="sidebarDesktopToggle" class="d-none d-md-flex" title="Toggle Sidebar" style="cursor: pointer; width: 36px; height: 36px; align-items: center; justify-content: center; border-radius: 10px; background: rgba(124, 58, 237, 0.1); color: var(--primary-purple); border: 1px solid rgba(124, 58, 237, 0.2);">
                    <i class="fas fa-angles-left" id="toggleIcon"></i>
                </div>
            </li>
            <hr class="text-secondary opacity-25 mx-3 mt-0 mb-3 sidebar-hr">

            <li class="nav-item mb-1">
                <a class="nav-link sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" data-label="Home">
                    <i class="fas fa-home sidebar-icon"></i>
                    <span class="sidebar-label">Home</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                @php
                    $isLedgerOrWalletActive = request()->routeIs(['run_balance.*', 'wallets.index', 'wallets.show']);
                @endphp
                <a class="nav-link sidebar-link {{ $isLedgerOrWalletActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#runBalanceMenu" role="button" aria-expanded="{{ $isLedgerOrWalletActive ? 'true' : 'false' }}" data-label="Ledger">
                    <i class="fas fa-book sidebar-icon"></i>
                    <span class="sidebar-label">Ledger</span>
                    <i class="fas fa-chevron-down chevron-icon ms-auto"></i>
                </a>
                <div class="collapse {{ $isLedgerOrWalletActive ? 'show' : '' }}" id="runBalanceMenu" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('run_balance.index') ? 'active' : '' }}" href="{{ route('run_balance.index') }}">
                                <i class="fas fa-users me-2"></i> <span>Customers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs(['wallets.index', 'wallets.show']) ? 'active' : '' }}" href="{{ route('wallets.index') }}">
                                <i class="fas fa-wallet me-2"></i> <span>Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('run_balance.customer_create') ? 'active' : '' }}" href="{{ route('run_balance.customer_create') }}">
                                <i class="fas fa-user-plus me-2"></i> <span>Add Customer</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                // Since wallet names are encrypted, we fetch all and filter in PHP
                $mainWallet = \App\Models\Wallet::all()->filter(fn($w) => $w->name === 'Safiullah zafar')->first() ?: \App\Models\Wallet::first();
                $isDiaryActive = request()->routeIs('wallets.expenses');
                $isBanksActive = request()->routeIs('banks.index');
            @endphp
            @if($mainWallet)
            <li class="nav-item mb-1">
                <a class="nav-link sidebar-link {{ $isDiaryActive ? 'active' : '' }}" href="{{ route('wallets.expenses', ['wallet' => $mainWallet->id, 'view' => 'all']) }}" data-label="Diary">
                    <i class="fas fa-book-open sidebar-icon"></i>
                    <span class="sidebar-label">Diary</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link sidebar-link {{ $isBanksActive ? 'active' : '' }}" href="{{ route('banks.index') }}" data-label="Banks">
                    <i class="fas fa-university sidebar-icon"></i>
                    <span class="sidebar-label">Banks</span>
                </a>
            </li>
            @endif

            <li class="nav-item mb-1">
                <a class="nav-link sidebar-link {{ request()->routeIs('wallets.net') ? 'active' : '' }}" href="{{ route('wallets.net') }}" data-label="Net Calculation">
                    <i class="fas fa-calculator sidebar-icon"></i>
                    <span class="sidebar-label">Net Calculation</span>
                </a>
            </li>
           
        </ul>

        <div class="sidebar-footer">
            <!-- Delete Customer Button -->
            @if(isset($customers) && $customers->count())
                <button id="sidebarDeleteBtn" type="button" class="logout-btn nav-link sidebar-link border-0 bg-transparent w-100 text-start position-relative mb-2" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal" data-label="Delete Hub">
                    <i class="fas fa-trash-alt sidebar-icon text-danger"></i>
                    <span class="sidebar-label text-danger fw-bold">Delete Customer</span>
                </button>
            @endif

            <hr class="text-secondary opacity-10 mx-2 sidebar-hr">

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn nav-link sidebar-link border-0 bg-transparent w-100 text-start position-relative" data-label="Logout">
                    <i class="fas fa-right-from-bracket sidebar-icon text-danger"></i>
                    <span class="sidebar-label text-danger fw-bold">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>
@endauth

<!-- Main content -->
<main>
    @yield('content')
</main>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('run_balance.delete_customer') }}">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">This will permanently delete the customer and all their transactions. Admin credentials are required.</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">-- Select customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Admin Name <span class="text-danger">*</span></label>
                        <input type="text" name="admin_name" class="form-control" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Admin Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="admin_password" id="adminPasswordInput" class="form-control" required autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="toggleAdminPassword">Show</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toast Trigger Logic
    document.addEventListener('DOMContentLoaded', function() {
        const toastEl = document.getElementById('statusToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            const toastMessage = document.getElementById('toastMessage');
            
            @if(session('status'))
                toastMessage.textContent = "{{ session('status') }}";
                toastEl.classList.add('bg-success');
                toast.show();
            @elseif(session('delete_error') || session('error'))
                toastMessage.textContent = "{{ session('delete_error') ?? session('error') }}";
                toastEl.classList.add('bg-danger');
                toast.show();
            @endif
        }

        // Initialize mobile sidebar state
        initializeMobileSidebar();
    });

    // Sidebar Toggle Logic (Desktop & Mobile)
    const sidebar = document.getElementById('sidebarMenu');
    const mainContent = document.querySelector('main');
    const desktopToggle = document.getElementById('sidebarDesktopToggle');
    const mobileToggle = document.getElementById('sidebarToggle');
    const mobileBackdrop = document.getElementById('mobileBackdrop');
    const toggleIcon = document.getElementById('toggleIcon');

    // Load initial state
    if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth >= 768) {
        applyCollapse();
    }

    function applyCollapse() {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
        if (toggleIcon) {
            toggleIcon.classList.remove('fa-angles-left');
            toggleIcon.classList.add('fa-angles-right');
        }
        // Update toggle label or title if needed
    }

    function removeCollapse() {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('collapsed');
        if (toggleIcon) {
            toggleIcon.classList.remove('fa-angles-right');
            toggleIcon.classList.add('fa-angles-left');
        }
    }

    if (desktopToggle) {
        desktopToggle.addEventListener('click', () => {
            // Mobile behavior
            if (window.innerWidth < 768) {
                if (sidebar.classList.contains('mobile-expanded')) {
                    // Collapse mobile sidebar
                    sidebar.classList.remove('mobile-expanded');
                    sidebar.classList.add('mobile-collapsed');
                    mobileBackdrop.classList.remove('show');
                    document.body.classList.remove('sidebar-mobile-expanded');
                    if (toggleIcon) {
                        toggleIcon.classList.remove('fa-angles-left');
                        toggleIcon.classList.add('fa-angles-right');
                    }
                } else {
                    // Expand mobile sidebar
                    sidebar.classList.remove('mobile-collapsed');
                    sidebar.classList.add('mobile-expanded');
                    mobileBackdrop.classList.add('show');
                    document.body.classList.add('sidebar-mobile-expanded');
                    if (toggleIcon) {
                        toggleIcon.classList.remove('fa-angles-right');
                        toggleIcon.classList.add('fa-angles-left');
                    }
                }
            } else {
                // Desktop behavior
                if (sidebar.classList.contains('collapsed')) {
                    removeCollapse();
                    localStorage.setItem('sidebarCollapsed', 'false');
                } else {
                    applyCollapse();
                    localStorage.setItem('sidebarCollapsed', 'true');
                }
            }
        });
    }

    // Expand sidebar when clicking a menu item that has sub-menu while collapsed
    document.addEventListener('click', function(e) {
        if (sidebar.classList.contains('collapsed')) {
            const link = e.target.closest('.nav-link[data-bs-toggle="collapse"]');
            if (link) {
                // Prevent default collapse behavior
                e.preventDefault();
                e.stopPropagation();
                
                // Expand sidebar
                removeCollapse();
                localStorage.setItem('sidebarCollapsed', 'false');
                
                // Open the specific menu item after a brief delay to allow transition
                setTimeout(() => {
                    const targetId = link.getAttribute('href');
                    const targetMenu = document.querySelector(targetId);
                    if (targetMenu) {
                        const bsCollapse = new bootstrap.Collapse(targetMenu, {
                            toggle: false
                        });
                        bsCollapse.show();
                        link.setAttribute('aria-expanded', 'true');
                    }
                }, 400);
            }
        }
    });

    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768 && 
            !sidebar.contains(e.target) && 
            !mobileToggle.contains(e.target) && 
            sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });

    // Mobile Sidebar Functionality
    function initializeMobileSidebar() {
        if (window.innerWidth < 768) {
            // Start with collapsed sidebar on mobile
            sidebar.classList.add('mobile-collapsed');
            sidebar.classList.remove('show');
            
            // Set initial icon state for mobile (collapsed = right arrow)
            if (toggleIcon) {
                toggleIcon.classList.remove('fa-angles-left');
                toggleIcon.classList.add('fa-angles-right');
            }
            
            // Add click handler for backdrop to close sidebar
            mobileBackdrop.addEventListener('click', () => {
                sidebar.classList.remove('mobile-expanded');
                sidebar.classList.add('mobile-collapsed');
                mobileBackdrop.classList.remove('show');
                document.body.classList.remove('sidebar-mobile-expanded');
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-angles-left');
                    toggleIcon.classList.add('fa-angles-right');
                }
            });
        }
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            // Clean up mobile states when switching to desktop
            sidebar.classList.remove('mobile-collapsed', 'mobile-expanded');
            mobileBackdrop.classList.remove('show');
            document.body.classList.remove('sidebar-mobile-expanded');
            
            // Reset icon to desktop state
            if (toggleIcon) {
                if (sidebar.classList.contains('collapsed')) {
                    toggleIcon.classList.remove('fa-angles-left');
                    toggleIcon.classList.add('fa-angles-right');
                } else {
                    toggleIcon.classList.remove('fa-angles-right');
                    toggleIcon.classList.add('fa-angles-left');
                }
            }
        } else {
            // Initialize mobile state when switching to mobile
            if (!sidebar.classList.contains('mobile-collapsed') && !sidebar.classList.contains('mobile-expanded')) {
                initializeMobileSidebar();
            }
        }
    });

    // Toggle admin password visibility
    const togglePasswordBtn = document.getElementById('toggleAdminPassword');
    if(togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function () {
            const input = document.getElementById('adminPasswordInput');
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'Hide';
            } else {
                input.type = 'password';
                this.textContent = 'Show';
            }
        });
    }
</script>

</body>
</html>
