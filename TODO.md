# خطة إصلاح مشكلة تسجيل الدخول والتسجيل للطبيب والمريض

## المشكلة
عند تسجيل الدخول أو التسجيل كطبيب أو مريض، لا يحدث شيء ولا يتم التوجيه للصفحات المطلوبة.

## الأسباب
1. جداول `patients` و `doctors` تفتقر لعمود `user_id`
2. جدول `doctors` يفتقر لأعمدة `experience`, `consultation_fee`, `about`
3. عمود `user_id` في `clinics` غير nullable (يسبب خطأ عند إنشاء عيادة للطبيب)
4. تشفير مزدوج لكلمة المرور في `AuthController` (User model يستخدم cast `hashed` + `Hash::make()`)

## الخطوات
- [x] 1. إنشاء migration: إضافة `user_id` إلى جدول `patients`
- [x] 2. إنشاء migration: إضافة `user_id` إلى جدول `doctors`
- [x] 3. إنشاء migration: إضافة أعمدة `experience`, `consultation_fee`, `about` إلى جدول `doctors`
- [x] 4. إنشاء migration: جعل `user_id` في `clinics` nullable
- [x] 5. تعديل `AuthController.php`: إزالة `Hash::make()` لمنع التشفير المزدوج
- [x] 6. تنفيذ `php artisan migrate`

