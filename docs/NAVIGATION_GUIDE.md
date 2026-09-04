# Cloud Khata navigation guide

This guide describes the main application navigation from the code in `resources/views/layouts/partials/header.blade.php` and `app/Http/Middleware/AdminSidebarMenu.php`.

## First: why buttons can be different for each user

The application does **not** show every button to every user. A menu item appears only when all required conditions are true:

1. The user has the required permission. Permissions are assigned from **User Management > Roles**.
2. The related business feature is enabled in **Settings > Business Settings**. For example: POS, purchases, expenses, accounts, stock transfers, tables, or bookings.
3. For add-on modules, the module is installed and active.

Manufacturing is intentionally disabled in this installation. It has no routes, sidebar entry, or Manage Modules entry.

## Top bar

From left to right, the main top bar contains the following controls.

| Button or dropdown | What it does | When it appears |
| --- | --- | --- |
| Mobile menu button | Opens the sidebar on small screens. | Small screens only. |
| Collapse sidebar | Minimizes or expands the left sidebar. | Desktop screens. |
| Active subscription | Shows subscription/package information. | Superadmin module is available. |
| Back to previous user | Returns a Superadmin to the user account they were impersonating. | Only while using “sign in as user”. |
| Plus dropdown | Opens quick actions: Calendar, Add To Do, and Application Tour. | Calendar is standard; To Do needs Essentials; Tour needs the business Admin role. |
| Calculator | Opens the built-in calculator popup. | Medium screen and wider. |
| POS Sale | Opens the POS sale screen. | POS is enabled and the user has `sell.create`. |
| Repair quick action | Opens the Repair module’s header action. | Repair module is installed and its header is enabled. |
| Today’s Profit | Opens today’s profit information. | User has `profit_loss_report.view`. |
| Date | Displays today’s date. | Large screens. |
| Bell | Opens unread notifications and loads more notifications when available. | Standard. |
| User dropdown | Opens Profile and Sign Out. | Standard. |

### User dropdown

- **Profile**: view or update the current user’s profile and password.
- **Sign Out**: clears the current session and returns to the login screen.

## Sidebar: normal working order

The business name at the top returns to **Home**. The green dot means the page is online. The remaining sidebar entries are described below in the order the application creates them.

### 1. Home

Opens the dashboard. Use it to see business summaries, charts, recent activity, and the dashboard widgets that your role can access.

### 2. User Management

Visible when the user can view/create users or view roles.

- **Users**: create, edit, activate/deactivate, and manage staff login access.
- **Roles**: create roles and choose what each role can view, create, update, or delete.
- **Sales Commission Agents**: manage staff who receive sales commission.

### 3. Contacts

Visible to users with customer or supplier access.

- **Suppliers**: companies/people you buy from.
- **Customers**: people/companies you sell to.
- **Customer Groups**: group customers for pricing, reporting, or organization.
- **Import Contacts**: upload contacts in bulk when create permission is available.
- **Map**: shows contact locations; only appears when `GOOGLE_MAP_API_KEY` is configured.

### 4. Products

Visible when the user has product, brand, unit, or category permission.

- **List Products**: browse, search, edit, duplicate, or remove products.
- **Add Product**: create a product, variations, prices, stock settings, and tax settings.
- **Update Product Price**: change selling prices in bulk.
- **Print Labels**: generate barcode/label sheets for selected products.
- **Variations**: manage reusable variation templates such as Size or Color.
- **Import Products**: upload product data in bulk.
- **Import Opening Stock**: import initial stock quantities and values.
- **Selling Price Groups**: maintain different price lists for different customer groups or locations.
- **Units**: manage units such as Piece, Kg, Box, or Litre.
- **Categories**: manage product categories/subcategories.
- **Brands**: manage product brands.
- **Warranties**: create warranty options used by products and sales.

### 5. Purchases

Visible only when the **Purchases** business feature is enabled and the user has purchase permission.

- **Purchase Requisition**: internal request to buy stock; shown only when enabled in Common Settings.
- **Purchase Order**: formal supplier order; shown only when enabled in Common Settings.
- **List Purchases**: see received/draft/pending purchases and payments.
- **Add Purchase**: enter a new supplier purchase and received stock.
- **List Purchase Return**: return purchased items to suppliers.

### 6. Sales

Visible when the user has at least one sales-related permission.

- **Sales Order**: customer order before final sale; needs Sales Order setting and permission.
- **All Sales**: search and manage completed/direct sales.
- **Add Sale**: create a direct sale/invoice without the POS screen.
- **List POS**: review POS sales.
- **POS Sale**: open the cashier POS screen.
- **Add Draft / List Drafts**: save a sale for later completion.
- **Add Quotation / List Quotations**: prepare and manage customer quotations.
- **List Sell Return**: process customer returns.
- **Shipments**: manage delivery/shipping information.
- **Discounts**: create product/category/date-based discounts.
- **Subscriptions**: recurring customer subscriptions; only when enabled.
- **Import Sales**: import sales from a spreadsheet.

### 7. Stock Transfers

Visible when **Stock Transfers** is enabled and the user has purchase access.

- **List Stock Transfers**: view transfers between business locations.
- **Add Stock Transfer**: send stock from one location to another.

### 8. Stock Adjustment

Visible when **Stock Adjustment** is enabled and the user has purchase access.

- **List Stock Adjustments**: view adjustments already made.
- **Add Stock Adjustment**: correct stock for damage, loss, counting differences, or expiry.

### 9. Expenses

Visible when **Expenses** is enabled and the user can access expenses.

- **List Expenses**: review recorded operating expenses.
- **Add Expense**: record an expense and payment details.
- **Expense Categories**: create categories such as Rent, Utilities, or Transport.

### 10. Payment Accounts

Visible when **Accounts** is enabled and the user has account access.

- **List Accounts**: manage cash, bank, and other payment accounts.
- **Balance Sheet**: assets, liabilities, and equity overview.
- **Trial Balance**: debit/credit balance check.
- **Cash Flow**: incoming and outgoing money analysis.
- **Payment Account Report**: account transactions and balances.

### 11. Reports

Visible when the user has at least one report permission. Each report is also permission-controlled.

- **Profit/Loss**: sales income, purchases, expenses, and profit.
- **Purchase & Sell Report**: compare purchasing and selling activity.
- **Tax Report**: sales/purchase tax totals.
- **Contacts / Customer Groups**: customer and supplier balances/activity.
- **Stock Report**: current stock, value, and movement.
- **Stock Expiry Report**: only when product expiry is enabled.
- **Lot Report**: only when lot numbers are enabled.
- **Stock Adjustment Report**: only when stock adjustment is enabled.
- **Trending Products**: products with strongest demand.
- **Items, Product Purchase, Product Sell**: product-level performance reports.
- **Purchase Payment / Sell Payment**: payment collection and payment-out reports.
- **Expense Report**: expense totals and filters.
- **Register Report**: cash-register opening, closing, and activity.
- **Sales Representative**: sales and commission staff results.
- **Table Report**: restaurant tables; only when tables are enabled.
- **GST Sales / GST Purchase**: only when the GST configuration is enabled.
- **Service Staff Report**: only when service staff is enabled.
- **Activity Log**: actions taken in the system; business Admin only.

### 12. Backup

Visible only to the Superadmin usernames configured through `ADMINISTRATOR_USERNAMES` in `.env`. Use it to create/download backups. Treat backup files as sensitive because they can contain business data.

### 13. Modules

Visible only to Superadmin usernames. This page manages installed modules. Manufacturing is specifically hidden and blocked in this project.

### 14. Restaurant/service menus

These only appear when their matching business features are enabled.

- **Bookings**: create and manage customer reservations.
- **Kitchen**: kitchen order queue and cooking status.
- **Orders**: service-staff order list and serving status.
- **Tables**: restaurant table setup, under Settings.
- **Modifiers**: product add-ons/modifiers, under Settings.
- **Types of Service**: delivery, dine-in, takeaway, etc., under Settings.

### 15. Notification Templates

Visible with `send_notifications` permission. Create reusable messages used for invoices, receipts, and other customer/staff notifications.

### 16. Settings

Visible when the user has one or more settings permissions.

- **Business Settings**: business profile, currency, date/time, enabled features, POS settings, tax labels, and operational preferences.
- **Business Locations**: create/manage branches, addresses, and location-specific settings.
- **Invoice Settings**: invoice schemes and layouts.
- **Barcode Settings**: barcode type and label configuration.
- **Receipt Printers**: configure compatible receipt printers.
- **Tax Rates**: create and manage tax percentages.
- **Tables, Modifiers, Types of Service**: restaurant-specific settings, when their features are enabled.

## Safe daily workflow

1. Set up **Settings** first: business details, locations, taxes, invoices, units, categories, and printers.
2. Add **Contacts**: suppliers and customers.
3. Add **Products** and then record opening stock or purchases.
4. Use **POS Sale** or **Add Sale** to make sales.
5. Use **Expenses**, **Payment Accounts**, and **Reports** for financial tracking.
6. Use **User Management > Roles** before giving staff access, so they only see the functions they need.

## If a button is missing

Check these in order:

1. Sign in with the correct user.
2. Go to **User Management > Roles** and grant the matching permission.
3. Go to **Settings > Business Settings** and enable the related business feature.
4. If it belongs to an add-on, confirm the module is installed/active and the business subscription allows it.
5. Log out and log back in so the business session refreshes.

## Code locations for future updates

- Sidebar rules: `app/Http/Middleware/AdminSidebarMenu.php`
- Top bar controls: `resources/views/layouts/partials/header.blade.php`
- Sidebar display: `resources/views/layouts/partials/sidebar.blade.php`
- Main application routes: `routes/web.php`
- Module availability check: `app/Utils/ModuleUtil.php`
 