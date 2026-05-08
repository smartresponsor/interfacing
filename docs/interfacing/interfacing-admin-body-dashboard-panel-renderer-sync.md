= Interfacing admin-body dashboard panel renderer sync

Interfacing owns the canonical provider renderer and browser-facing mount template for admin-body/dashboard surfaces. App may publish compiled provider assets, but cache-busted script/style URLs and dashboard renderer expectations remain Interfacing-owned. Dashboard data must arrive as `dashboard.metrics`, `dashboard.sections`, `dashboard.widgets`, and `dashboard.sidePanels`, and must not be replaced by Twig shell panels, Bootstrap, EasyAdmin, or handmade CSS shells.
