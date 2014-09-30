<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Absolute_Positioner' => $vendorDir . '/dompdf/dompdf/include/absolute_positioner.cls.php',
    'Abstract_Renderer' => $vendorDir . '/dompdf/dompdf/include/abstract_renderer.cls.php',
    'Account' => $baseDir . '/app/models/Account.php',
    'AccountController' => $baseDir . '/app/controllers/AccountController.php',
    'Action' => $baseDir . '/app/models/Action.php',
    'ActionChange' => $baseDir . '/app/models/ActionChange.php',
    'ActionChangesController' => $baseDir . '/app/controllers/ActionChangesController.php',
    'ActionObject' => $baseDir . '/app/models/ActionObject.php',
    'ActionObjectsController' => $baseDir . '/app/controllers/ActionObjectsController.php',
    'ActionsController' => $baseDir . '/app/controllers/ActionsController.php',
    'ActivitiesController' => $baseDir . '/app/controllers/ActivitiesController.php',
    'Activity' => $baseDir . '/app/models/Activity.php',
    'ActivityReminderEmailCommand' => $baseDir . '/app/commands/ActivityReminderEmail.php',
    'AddAddressFieldsToUsersTable' => $baseDir . '/app/database/migrations/2014_08_27_135013_add_address_fields_to_users_table.php',
    'AddAvatarColumnToActivitiesTable' => $baseDir . '/app/database/migrations/2014_09_03_091156_add_avatar_column_to_activities_table.php',
    'AddBioColumnToUsersClientsTable' => $baseDir . '/app/database/migrations/2014_08_28_145518_add_bio_column_to_users_clients_table.php',
    'AddCancelledColumnToActivities' => $baseDir . '/app/database/migrations/2014_08_07_143739_add_cancelled_column_to_activities.php',
    'AddCashierColumns' => $baseDir . '/app/database/migrations/2014_07_21_143914_add_cashier_columns.php',
    'AddCashierColumnsToUsersTable' => $baseDir . '/app/database/migrations/2014_09_30_131212_add_cashier_columns_to_users_table.php',
    'AddClosedColumnToActivitiesTable' => $baseDir . '/app/database/migrations/2014_08_08_113735_add_closed_column_to_activities_table.php',
    'AddCreditsColumnToInstructorsTable' => $baseDir . '/app/database/migrations/2014_07_10_115133_add_credits_column_to_instructors_table.php',
    'AddPageViewsColumnToUsersInstructorsTable' => $baseDir . '/app/database/migrations/2014_09_02_095634_add_page_views_column_to_users_instructors_table.php',
    'AddRememeberTokenToUsersTable' => $baseDir . '/app/database/migrations/2014_06_30_150241_add_rememeber_token_to_users_table.php',
    'AddSocialColumnsToUsersClientsTable' => $baseDir . '/app/database/migrations/2014_08_28_144255_add_social_columns_to_users_clients_table.php',
    'AddStripeTokenAndPurchasedColumnsToCreditsTable' => $baseDir . '/app/database/migrations/2014_07_18_134556_add_stripe_token_and_purchased_columns_to_credits_table.php',
    'AddSuspendedColumnToUsersTable' => $baseDir . '/app/database/migrations/2014_09_02_125202_add_suspended_column_to_users_table.php',
    'AddUserTypeIdColumnToUsersTable' => $baseDir . '/app/database/migrations/2014_08_26_140827_add_user_type_id_column_to_users_table.php',
    'Admin' => $baseDir . '/app/models/Admin.php',
    'Adobe_Font_Metrics' => $vendorDir . '/phenx/php-font-lib/classes/Adobe_Font_Metrics.php',
    'Attribute_Translator' => $vendorDir . '/dompdf/dompdf/include/attribute_translator.cls.php',
    'AuthController' => $baseDir . '/app/controllers/AuthController.php',
    'Base' => $baseDir . '/app/models/Base.php',
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'Block_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/block_frame_decorator.cls.php',
    'Block_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/block_frame_reflower.cls.php',
    'Block_Positioner' => $vendorDir . '/dompdf/dompdf/include/block_positioner.cls.php',
    'Block_Renderer' => $vendorDir . '/dompdf/dompdf/include/block_renderer.cls.php',
    'CPDF_Adapter' => $vendorDir . '/dompdf/dompdf/include/cpdf_adapter.cls.php',
    'CSS_Color' => $vendorDir . '/dompdf/dompdf/include/css_color.cls.php',
    'Cached_PDF_Decorator' => $vendorDir . '/dompdf/dompdf/include/cached_pdf_decorator.cls.php',
    'Canvas' => $vendorDir . '/dompdf/dompdf/include/canvas.cls.php',
    'Canvas_Factory' => $vendorDir . '/dompdf/dompdf/include/canvas_factory.cls.php',
    'Cellmap' => $vendorDir . '/dompdf/dompdf/include/cellmap.cls.php',
    'ClassType' => $baseDir . '/app/models/ClassType.php',
    'ClassTypesController' => $baseDir . '/app/controllers/ClassTypesController.php',
    'ClassTypesTableSeeder' => $baseDir . '/app/database/seeds/ClassTypesTableSeeder.php',
    'Client' => $baseDir . '/app/models/Client.php',
    'CreateActionChangesTable' => $baseDir . '/app/database/migrations/2014_08_29_130140_create_actionChanges_table.php',
    'CreateActionObjectsTable' => $baseDir . '/app/database/migrations/2014_08_29_125931_create_actionObjects_table.php',
    'CreateActionsTable' => $baseDir . '/app/database/migrations/2014_08_29_124922_create_actions_table.php',
    'CreateActivitiesTable' => $baseDir . '/app/database/migrations/2014_06_30_125931_create_activities_table.php',
    'CreateActivityClassTypeTable' => $baseDir . '/app/database/migrations/2014_06_30_132331_create_activity_class_type_table.php',
    'CreateActivityFavouriteTable' => $baseDir . '/app/database/migrations/2014_07_01_090620_create_activity_favourite_table.php',
    'CreateActivityUserTable' => $baseDir . '/app/database/migrations/2014_06_30_151250_create_activity_user_table.php',
    'CreateClassTypesTable' => $baseDir . '/app/database/migrations/2014_06_30_124851_create_ClassTypes_table.php',
    'CreateCreditsTable' => $baseDir . '/app/database/migrations/2014_07_10_114427_create_credits_table.php',
    'CreateFeedbackItemsTable' => $baseDir . '/app/database/migrations/2014_07_08_124947_create_feedback_items_table.php',
    'CreateFeedbackTable' => $baseDir . '/app/database/migrations/2014_07_08_130220_create_feedback_table.php',
    'CreateFeedbackValuesTable' => $baseDir . '/app/database/migrations/2014_07_08_130028_create_feedback_values_table.php',
    'CreateFollowClientsTable' => $baseDir . '/app/database/migrations/2014_08_26_142843_create_follow_clients_table.php',
    'CreateFollowInstructorsTable' => $baseDir . '/app/database/migrations/2014_08_26_142907_create_follow_instructors_table.php',
    'CreateLevelsTable' => $baseDir . '/app/database/migrations/2014_07_29_105221_create_levels_table.php',
    'CreateMessagesTable' => $baseDir . '/app/database/migrations/2014_07_07_143616_create_messages_table.php',
    'CreatePasswordRemindersTable' => $baseDir . '/app/database/migrations/2014_06_30_132401_create_password_reminders_table.php',
    'CreateRolesTable' => $baseDir . '/app/database/migrations/2014_06_30_110939_create_roles_table.php',
    'CreateUserTypesTable' => $baseDir . '/app/database/migrations/2014_08_26_140530_create_user_types_table.php',
    'CreateUsersAdminsTable' => $baseDir . '/app/database/migrations/2014_06_30_112541_create_users_admins_table.php',
    'CreateUsersClientsTable' => $baseDir . '/app/database/migrations/2014_06_30_105704_create_users_clients_table.php',
    'CreateUsersInstructorsTable' => $baseDir . '/app/database/migrations/2014_06_30_100312_create_users_instructors_table.php',
    'CreateUsersTable' => $baseDir . '/app/database/migrations/2014_06_26_115032_create_users_table.php',
    'Credit' => $baseDir . '/app/models/Credit.php',
    'DOMPDF' => $vendorDir . '/dompdf/dompdf/include/dompdf.cls.php',
    'DOMPDF_Exception' => $vendorDir . '/dompdf/dompdf/include/dompdf_exception.cls.php',
    'DOMPDF_Image_Exception' => $vendorDir . '/dompdf/dompdf/include/dompdf_image_exception.cls.php',
    'DashboardController' => $baseDir . '/app/controllers/DashboardController.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'Encoding_Map' => $vendorDir . '/phenx/php-font-lib/classes/Encoding_Map.php',
    'Fedeisas\\LaravelJsRoutes\\Commands\\RoutesJavascriptCommand' => $vendorDir . '/fedeisas/laravel-js-routes/src/Commands/RoutesJavascriptCommand.php',
    'Fedeisas\\LaravelJsRoutes\\Generators\\RoutesJavascriptGenerator' => $vendorDir . '/fedeisas/laravel-js-routes/src/Generators/RoutesJavascriptGenerator.php',
    'Feedback' => $baseDir . '/app/models/Feedback.php',
    'FeedbackController' => $baseDir . '/app/controllers/FeedbackController.php',
    'FeedbackItem' => $baseDir . '/app/models/FeedbackItem.php',
    'FeedbackItemsTableSeeder' => $baseDir . '/app/database/seeds/FeedbackItemsTableSeeder.php',
    'FeedbackValue' => $baseDir . '/app/models/FeedbackValue.php',
    'Fixed_Positioner' => $vendorDir . '/dompdf/dompdf/include/fixed_positioner.cls.php',
    'Font' => $vendorDir . '/phenx/php-font-lib/classes/Font.php',
    'Font_Binary_Stream' => $vendorDir . '/phenx/php-font-lib/classes/Font_Binary_Stream.php',
    'Font_EOT' => $vendorDir . '/phenx/php-font-lib/classes/Font_EOT.php',
    'Font_EOT_Header' => $vendorDir . '/phenx/php-font-lib/classes/Font_EOT_Header.php',
    'Font_Glyph_Outline' => $vendorDir . '/phenx/php-font-lib/classes/Font_Glyph_Outline.php',
    'Font_Glyph_Outline_Component' => $vendorDir . '/phenx/php-font-lib/classes/Font_Glyph_Outline_Component.php',
    'Font_Glyph_Outline_Composite' => $vendorDir . '/phenx/php-font-lib/classes/Font_Glyph_Outline_Composite.php',
    'Font_Glyph_Outline_Simple' => $vendorDir . '/phenx/php-font-lib/classes/Font_Glyph_Outline_Simple.php',
    'Font_Header' => $vendorDir . '/phenx/php-font-lib/classes/Font_Header.php',
    'Font_Metrics' => $vendorDir . '/dompdf/dompdf/include/font_metrics.cls.php',
    'Font_OpenType' => $vendorDir . '/phenx/php-font-lib/classes/Font_OpenType.php',
    'Font_OpenType_Table_Directory_Entry' => $vendorDir . '/phenx/php-font-lib/classes/Font_OpenType_Table_Directory_Entry.php',
    'Font_Table' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table.php',
    'Font_Table_Directory_Entry' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_Directory_Entry.php',
    'Font_Table_cmap' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_cmap.php',
    'Font_Table_glyf' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_glyf.php',
    'Font_Table_head' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_head.php',
    'Font_Table_hhea' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_hhea.php',
    'Font_Table_hmtx' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_hmtx.php',
    'Font_Table_kern' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_kern.php',
    'Font_Table_loca' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_loca.php',
    'Font_Table_maxp' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_maxp.php',
    'Font_Table_name' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_name.php',
    'Font_Table_name_Record' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_name_Record.php',
    'Font_Table_os2' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_os2.php',
    'Font_Table_post' => $vendorDir . '/phenx/php-font-lib/classes/Font_Table_post.php',
    'Font_TrueType' => $vendorDir . '/phenx/php-font-lib/classes/Font_TrueType.php',
    'Font_TrueType_Collection' => $vendorDir . '/phenx/php-font-lib/classes/Font_TrueType_Collection.php',
    'Font_TrueType_Header' => $vendorDir . '/phenx/php-font-lib/classes/Font_TrueType_Header.php',
    'Font_TrueType_Table_Directory_Entry' => $vendorDir . '/phenx/php-font-lib/classes/Font_TrueType_Table_Directory_Entry.php',
    'Font_WOFF' => $vendorDir . '/phenx/php-font-lib/classes/Font_WOFF.php',
    'Font_WOFF_Header' => $vendorDir . '/phenx/php-font-lib/classes/Font_WOFF_Header.php',
    'Font_WOFF_Table_Directory_Entry' => $vendorDir . '/phenx/php-font-lib/classes/Font_WOFF_Table_Directory_Entry.php',
    'Frame' => $vendorDir . '/dompdf/dompdf/include/frame.cls.php',
    'FrameList' => $vendorDir . '/dompdf/dompdf/include/frame.cls.php',
    'FrameListIterator' => $vendorDir . '/dompdf/dompdf/include/frame.cls.php',
    'FrameTreeIterator' => $vendorDir . '/dompdf/dompdf/include/frame.cls.php',
    'FrameTreeList' => $vendorDir . '/dompdf/dompdf/include/frame.cls.php',
    'Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/frame_decorator.cls.php',
    'Frame_Factory' => $vendorDir . '/dompdf/dompdf/include/frame_factory.cls.php',
    'Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/frame_reflower.cls.php',
    'Frame_Tree' => $vendorDir . '/dompdf/dompdf/include/frame_tree.cls.php',
    'GD_Adapter' => $vendorDir . '/dompdf/dompdf/include/gd_adapter.cls.php',
    'HomeController' => $baseDir . '/app/controllers/HomeController.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'Image_Cache' => $vendorDir . '/dompdf/dompdf/include/image_cache.cls.php',
    'Image_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/image_frame_decorator.cls.php',
    'Image_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/image_frame_reflower.cls.php',
    'Image_Renderer' => $vendorDir . '/dompdf/dompdf/include/image_renderer.cls.php',
    'Inline_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/inline_frame_decorator.cls.php',
    'Inline_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/inline_frame_reflower.cls.php',
    'Inline_Positioner' => $vendorDir . '/dompdf/dompdf/include/inline_positioner.cls.php',
    'Inline_Renderer' => $vendorDir . '/dompdf/dompdf/include/inline_renderer.cls.php',
    'Instructor' => $baseDir . '/app/models/Instructor.php',
    'Javascript_Embedder' => $vendorDir . '/dompdf/dompdf/include/javascript_embedder.cls.php',
    'Level' => $baseDir . '/app/models/Level.php',
    'LevelsTableSeeder' => $baseDir . '/app/database/seeds/LevelsTableSeeder.php',
    'Line_Box' => $vendorDir . '/dompdf/dompdf/include/line_box.cls.php',
    'List_Bullet_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/list_bullet_frame_decorator.cls.php',
    'List_Bullet_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/list_bullet_frame_reflower.cls.php',
    'List_Bullet_Image_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/list_bullet_image_frame_decorator.cls.php',
    'List_Bullet_Positioner' => $vendorDir . '/dompdf/dompdf/include/list_bullet_positioner.cls.php',
    'List_Bullet_Renderer' => $vendorDir . '/dompdf/dompdf/include/list_bullet_renderer.cls.php',
    'Marketing' => $baseDir . '/app/models/Marketing.php',
    'MarketingController' => $baseDir . '/app/controllers/MarketingController.php',
    'Message' => $baseDir . '/app/models/Message.php',
    'MessagesController' => $baseDir . '/app/controllers/MessagesController.php',
    'Null_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/null_frame_decorator.cls.php',
    'Null_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/null_frame_reflower.cls.php',
    'Null_Positioner' => $vendorDir . '/dompdf/dompdf/include/null_positioner.cls.php',
    'PDFLib_Adapter' => $vendorDir . '/dompdf/dompdf/include/pdflib_adapter.cls.php',
    'PHP_Evaluator' => $vendorDir . '/dompdf/dompdf/include/php_evaluator.cls.php',
    'Page_Cache' => $vendorDir . '/dompdf/dompdf/include/page_cache.cls.php',
    'Page_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/page_frame_decorator.cls.php',
    'Page_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/page_frame_reflower.cls.php',
    'Positioner' => $vendorDir . '/dompdf/dompdf/include/positioner.cls.php',
    'RemindersController' => $baseDir . '/app/controllers/RemindersController.php',
    'Renderer' => $vendorDir . '/dompdf/dompdf/include/renderer.cls.php',
    'ReplenishCreditsCommand' => $baseDir . '/app/commands/ReplenishCredits.php',
    'Role' => $baseDir . '/app/models/Role.php',
    'RolesTableSeeder' => $baseDir . '/app/database/seeds/RolesTableSeeder.php',
    'SearchController' => $baseDir . '/app/controllers/SearchController.php',
    'Services\\Composers\\AdminSidebarComposer' => $baseDir . '/app/services/composers/AdminSidebarComposer.php',
    'Services\\Composers\\ClassTypeFormComposer' => $baseDir . '/app/services/composers/ClassTypeFormComposer.php',
    'Services\\Composers\\SearchComposer' => $baseDir . '/app/services/composers/SearchComposer.php',
    'Services\\Composers\\SocialComposer' => $baseDir . '/app/services/composers/SocialComposer.php',
    'Services\\Interfaces\\AccountInterface' => $baseDir . '/app/services/interfaces/AccountInterface.php',
    'Services\\Interfaces\\MailerInterface' => $baseDir . '/app/services/interfaces/MailerInterface.php',
    'Services\\Interfaces\\SearchInterface' => $baseDir . '/app/services/interfaces/SearchInterface.php',
    'Services\\Interfaces\\UploadInterface' => $baseDir . '/app/services/interfaces/UploadInterface.php',
    'Services\\Repositories\\ActionRepository' => $baseDir . '/app/services/repositories/ActionRepository.php',
    'Services\\Repositories\\ActivityRepository' => $baseDir . '/app/services/repositories/ActivityRepository.php',
    'Services\\Repositories\\DefaultMailer' => $baseDir . '/app/services/repositories/DefaultMailer.php',
    'Services\\Repositories\\DefaultSearch' => $baseDir . '/app/services/repositories/DefaultSearch.php',
    'Services\\Repositories\\DefaultUpload' => $baseDir . '/app/services/repositories/UploadsRepository.php',
    'Services\\Repositories\\HelperRepository' => $baseDir . '/app/services/repositories/HelperRepository.php',
    'Services\\Repositories\\StripeAccount' => $baseDir . '/app/services/repositories/StripeAccount.php',
    'Services\\Validators\\Activity' => $baseDir . '/app/services/validators/Activity.php',
    'Services\\Validators\\ClassType' => $baseDir . '/app/services/validators/ClassType.php',
    'Services\\Validators\\Message' => $baseDir . '/app/services/validators/Message.php',
    'Services\\Validators\\User' => $baseDir . '/app/services/validators/User.php',
    'Services\\Validators\\Validator' => $baseDir . '/app/services/validators/Validator.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'Stripe' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Stripe.php',
    'Stripe_Account' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Account.php',
    'Stripe_ApiConnectionError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApiConnectionError.php',
    'Stripe_ApiError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApiError.php',
    'Stripe_ApiRequestor' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApiRequestor.php',
    'Stripe_ApiResource' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApiResource.php',
    'Stripe_ApplicationFee' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApplicationFee.php',
    'Stripe_ApplicationFeeRefund' => $vendorDir . '/stripe/stripe-php/lib/Stripe/ApplicationFeeRefund.php',
    'Stripe_AttachedObject' => $vendorDir . '/stripe/stripe-php/lib/Stripe/AttachedObject.php',
    'Stripe_AuthenticationError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/AuthenticationError.php',
    'Stripe_Balance' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Balance.php',
    'Stripe_BalanceTransaction' => $vendorDir . '/stripe/stripe-php/lib/Stripe/BalanceTransaction.php',
    'Stripe_Card' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Card.php',
    'Stripe_CardError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/CardError.php',
    'Stripe_Charge' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Charge.php',
    'Stripe_Coupon' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Coupon.php',
    'Stripe_Customer' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Customer.php',
    'Stripe_Error' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Error.php',
    'Stripe_Event' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Event.php',
    'Stripe_InvalidRequestError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/InvalidRequestError.php',
    'Stripe_Invoice' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Invoice.php',
    'Stripe_InvoiceItem' => $vendorDir . '/stripe/stripe-php/lib/Stripe/InvoiceItem.php',
    'Stripe_List' => $vendorDir . '/stripe/stripe-php/lib/Stripe/List.php',
    'Stripe_Object' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Object.php',
    'Stripe_Plan' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Plan.php',
    'Stripe_RateLimitError' => $vendorDir . '/stripe/stripe-php/lib/Stripe/RateLimitError.php',
    'Stripe_Recipient' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Recipient.php',
    'Stripe_Refund' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Refund.php',
    'Stripe_SingletonApiResource' => $vendorDir . '/stripe/stripe-php/lib/Stripe/SingletonApiResource.php',
    'Stripe_Subscription' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Subscription.php',
    'Stripe_Token' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Token.php',
    'Stripe_Transfer' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Transfer.php',
    'Stripe_Util' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Util.php',
    'Stripe_Util_Set' => $vendorDir . '/stripe/stripe-php/lib/Stripe/Util/Set.php',
    'Style' => $vendorDir . '/dompdf/dompdf/include/style.cls.php',
    'Stylesheet' => $vendorDir . '/dompdf/dompdf/include/stylesheet.cls.php',
    'TCPDF_Adapter' => $vendorDir . '/dompdf/dompdf/include/tcpdf_adapter.cls.php',
    'Table_Cell_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/table_cell_frame_decorator.cls.php',
    'Table_Cell_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/table_cell_frame_reflower.cls.php',
    'Table_Cell_Positioner' => $vendorDir . '/dompdf/dompdf/include/table_cell_positioner.cls.php',
    'Table_Cell_Renderer' => $vendorDir . '/dompdf/dompdf/include/table_cell_renderer.cls.php',
    'Table_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/table_frame_decorator.cls.php',
    'Table_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/table_frame_reflower.cls.php',
    'Table_Row_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/table_row_frame_decorator.cls.php',
    'Table_Row_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/table_row_frame_reflower.cls.php',
    'Table_Row_Group_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/table_row_group_frame_decorator.cls.php',
    'Table_Row_Group_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/table_row_group_frame_reflower.cls.php',
    'Table_Row_Group_Renderer' => $vendorDir . '/dompdf/dompdf/include/table_row_group_renderer.cls.php',
    'Table_Row_Positioner' => $vendorDir . '/dompdf/dompdf/include/table_row_positioner.cls.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'Text_Frame_Decorator' => $vendorDir . '/dompdf/dompdf/include/text_frame_decorator.cls.php',
    'Text_Frame_Reflower' => $vendorDir . '/dompdf/dompdf/include/text_frame_reflower.cls.php',
    'Text_Renderer' => $vendorDir . '/dompdf/dompdf/include/text_renderer.cls.php',
    'UpdateTimeColumnsOnActivitiesTable' => $baseDir . '/app/database/migrations/2014_07_04_141108_update_time_columns_on_activities_table.php',
    'User' => $baseDir . '/app/models/User.php',
    'UserType' => $baseDir . '/app/models/UserType.php',
    'UserTypesTableSeeder' => $baseDir . '/app/database/seeds/UserTypesTableSeeder.php',
    'UsersController' => $baseDir . '/app/controllers/UsersController.php',
    'UsersTableSeeder' => $baseDir . '/app/database/seeds/UsersTableSeeder.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
);
