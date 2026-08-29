<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleMovementController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BourseController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\Bulletins\BulletinMaternelleController;
use App\Http\Controllers\Bulletins\BulletinPrimaireController;
use App\Http\Controllers\Bulletins\BulletinSecondaireController;
use App\Http\Controllers\CashInController;
use App\Http\Controllers\ExtraCashinsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DeviceTokenController;


use App\Http\Controllers\InfosEcoleController;
use App\Http\Controllers\Documents\CertificatDeTransfertController;
use App\Http\Controllers\LessonSummaryController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MarkOnlineExamController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\MobileBuildVersionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\HomeworkDoneController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MoratoriumController;
use App\Http\Controllers\MoyenneController;
use App\Http\Controllers\MtnPaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageLivreController;
use App\Http\Controllers\PaymentTransportUserController;
use App\Http\Controllers\MeetingReportController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PropositionQuestionController;
use App\Http\Controllers\ExplanationRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReglementInterieurController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RequeteController;
use App\Http\Controllers\RH\HolidayController;
use App\Http\Controllers\RH\NoteFraisController;
use App\Http\Controllers\SalaryAdvanceController;
use App\Http\Controllers\SalaryComponentController;
use App\Http\Controllers\SalaryDeductionController;
use App\Http\Controllers\ScanReceiptController;
use App\Http\Controllers\SchoolExamController;
use App\Http\Controllers\SchoolDelayController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\LitigeController;
use App\Http\Controllers\SupplyDemandController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TransportUserController;
use App\Http\Controllers\TypeInvoiceController;
use App\Http\Controllers\TypeOfRecipeController;
use App\Http\Controllers\TypeRequeteController;
use App\Http\Controllers\WarningController;
use App\Http\Controllers\TutorialController;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\OptionLevelController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;

use App\Http\Controllers\MatterController;
use App\Http\Controllers\MatterGroupController;
use App\Http\Controllers\CoefficientController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\PensionController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\TrancheController;
use App\Http\Controllers\SchoolFolderController;
use App\Http\Controllers\PensionUserController;

use App\Http\Controllers\SchoolSupplyController;
use App\Http\Controllers\TeacherObservationController;
use App\Http\Controllers\ParentalMonitoringController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AssessmentTypeController;
use App\Http\Controllers\ExamStudentController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\FeeUserController;
use App\Http\Controllers\OrangeApiController;
use App\Http\Controllers\PresenceTeacherController;
use App\Http\Controllers\ResponseStudentController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\WithdrawalController;

use App\Http\Controllers\TypeEvaluationController;
use App\Http\Controllers\TrimestreController;

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'signup']);
Route::post('findlicence', [KeyController::class,'getroute']);
Route::post('makewebpayment2', [OrangeApiController::class,'makePaymentWithStatusCheck']);
Route::post('uploadphotos', [RegisterController::class, 'uploadphotos'])->name('uploadphotos');

Route::post('/om/callback', [OrangeApiController::class, 'handleCallback'])->name('om.callback');

Route::group(['middleware' => ['auth:sanctum', 'setLocale']],function() {


    Route::post('makewebpayment', [OrangeApiController::class, 'makeWebPayment']);
    Route::get('getstatuspayment/{id}', [OrangeApiController::class, 'getStatusPayment']);

    Route::post('makemobpayment', [OrangeApiController::class, 'makeMerchantPayRequest']);
    Route::get('getstatuspaymentmob/{id}', [OrangeApiController::class, 'getPaymentStatusMob']);

    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('user', [UserController::class, 'getuser']);
    Route::post('transfertdatauser', [UserController::class, 'transferDataUser']);
    Route::post('insolvableinscription', [UserController::class, 'insolvableInscription']);
    Route::post('dashboardfounder', [UserController::class, 'dashboardFounder']);
    Route::post('financedetail', [UserController::class, 'financeDetailFounder']);
    Route::post('financedetailparclasse', [UserController::class, 'financeDetailFounderPerClasse']);
    Route::post('financedetailpartranche', [UserController::class, 'financeDetailFounderPerOrdreTranche']);
    Route::post('dashboardparent', [UserController::class, 'dashboardParent']);
    Route::post('dashboardteacher', [UserController::class, 'dashboardTeacher']);
    Route::post('dashboardcomptable', [UserController::class, 'dashboardComptable']);
    Route::post('omstat', [UserController::class, 'statistiqueOM']);
    Route::post('/store-token', [DeviceTokenController::class, 'update'])->name('store.token');
    Route::post('/send-web-notification', [UserController::class, 'sendNotification'])->name('send.web-notification');
    Route::post('/send-android-notification', [UserController::class, 'sendNotificationAndroid'])->name('send.android-notification');
    Route::post('pensiontranchefee', [PensionController::class, 'pensionTrancheFees']);

    Route::post('permissions', [PermissionController::class, 'store']);
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::put('permissions/{id}', [PermissionController::class, 'update']);
    Route::delete('permissions/{id}', [PermissionController::class, 'destroy']);

    Route::post('roles', [RoleController::class, 'store']);
    Route::post('rolesall', [RoleController::class, 'index']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);

    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'index']);
    Route::post('users-reset-password', [ResetPasswordController::class, 'resetPasswordByAdmin']);
    Route::post('usersar/{id}', [UserController::class, 'archive']);
    Route::post('users/restore', [UserController::class, 'restoreBulk']);
    Route::post('userspassword', [UserController::class, 'updatepassword']);
    Route::post('users/bulk-delete', [UserController::class, 'deleteInBulk']);
    Route::post('users/generer-certificat-scolarite', [DocumentController::class, "genererCertificatScolarite"]);
    Route::post('users/carte-scolaire', [DocumentController::class, "genererCarteScolaire"]);
    Route::post('users/bulletin-paie', [DocumentController::class, "genererBulletinPaie"]);
    Route::post('upload-pdf', [DocumentController::class, 'uploadPdf']);
    Route::put('users/mobile-build-version', [MobileBuildVersionController::class, 'updateUserBuildVersion']);
    Route::post('users/switch-classe', [UserController::class, 'switchUserClasse']);
    Route::post('users/switch-classe-secondaire', [UserController::class, 'switchUserClasseSecondaire']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::post('users/payments', [UserController::class, 'payments']);
    Route::post('usersstudent', [UserController::class, 'usersstudent']);

    Route::get('packages', [PackageController::class, 'index']);
    Route::post('packages', [PackageController::class, 'store']);
    Route::get('packages/{id}', [PackageController::class, 'show']);
    Route::put('packages/{id}', [PackageController::class, 'update']);
    Route::delete('packages/{id}', [PackageController::class, 'destroy']);
    Route::post('packages/trash', [PackageController::class, 'trashBulk']);
    Route::post('packages/restore', [PackageController::class, 'restoreBulk']);
    Route::post('packages/delete', [PackageController::class, 'destroyBulk']);

    Route::post('withdrawalsall', [WithdrawalController::class, 'index']);
    Route::post('withdrawals', [WithdrawalController::class, 'store']);
    Route::post('withdrawalsconfirm', [WithdrawalController::class, 'confirmcode']);
    Route::get('withdrawals/{id}', [WithdrawalController::class, 'show']);
    Route::put('withdrawals/{id}', [WithdrawalController::class, 'update']);
    Route::delete('withdrawals/{id}', [WithdrawalController::class, 'destroy']);

    Route::post('academic-yearsall', [AcademicYearController::class, 'index']);
    Route::post('academic-years', [AcademicYearController::class, 'store']);
    Route::get('academic-years/{id}', [AcademicYearController::class, 'show']);
    Route::put('academic-years/{id}', [AcademicYearController::class, 'update']);
    Route::delete('academic-years/{id}', [AcademicYearController::class, 'destroy']);
    Route::post("academic-years/trash", [AcademicYearController::class, "trash"]);
    Route::post("academic-years/restore", [AcademicYearController::class, "restore"]);

    Route::post('establishmentsall', [EstablishmentController::class, 'index']);
    Route::get('establishments/{id}', [EstablishmentController::class, 'show']);
    Route::post('establishments', [EstablishmentController::class, 'store']);
    Route::put('establishments/{id}', [EstablishmentController::class, 'update']);
    Route::delete('establishments/{id}', [EstablishmentController::class, 'destroy']);
    Route::post('establishments/trash', [EstablishmentController::class, 'trashBulk']);
    Route::post('establishments/restore', [EstablishmentController::class, 'restoreBulk']);
    Route::post('establishments/delete', [EstablishmentController::class, 'destroyBulk']);

    Route::post('schoolsall', [SchoolController::class, 'index']);
    Route::get('schools/{id}', [SchoolController::class, 'show']);
    Route::post('schools', [SchoolController::class, 'store']);
    Route::put('schools/{id}', [SchoolController::class, 'update']);
    Route::delete('schools/{id}', [SchoolController::class, 'destroy']);
    Route::post('schools/trash', [SchoolController::class, 'trashBulk']);
    Route::post('schools/restore', [SchoolController::class, 'restoreBulk']);
    Route::post('schools/delete', [SchoolController::class, 'destroyBulk']);

    Route::post('campusall', [CampusController::class, 'index']);
    Route::get('campus/{id}', [CampusController::class, 'show']);
    Route::post('campus', [CampusController::class, 'store']);
    Route::put('campus/{id}', [CampusController::class, 'update']);
    Route::delete('campus/{id}', [CampusController::class, 'destroy']);
    Route::post('campus/trash', [CampusController::class, 'trashBulk']);
    Route::post('campus/restore', [CampusController::class, 'restoreBulk']);
    Route::post('campus/delete', [CampusController::class, 'destroyBulk']);

    Route::post('sectionsall', [SectionController::class, 'index']);
    Route::get('sections/{id}', [SectionController::class, 'show']);
    Route::post('sections', [SectionController::class, 'store']);
    Route::put('sections/{id}', [SectionController::class, 'update']);
    Route::delete('sections/{id}', [SectionController::class, 'destroy']);
    Route::post('sections/trash', [SectionController::class, 'trashBulk']);
    Route::post('sections/restore', [SectionController::class, 'restoreBulk']);
    Route::post('sections/delete', [SectionController::class, 'destroyBulk']);

    Route::post('invoicesall', [InvoiceController::class, 'index']);
    Route::get('invoices/{id}', [InvoiceController::class, 'show']);
    Route::post('invoices', [InvoiceController::class, 'store']);
    Route::post('invoices/trash', [InvoiceController::class, 'archive']);
    Route::post('invoices/restore', [InvoiceController::class, 'restore']);
    Route::post('invoices/duplicate', [InvoiceController::class, 'duplicateInvoices']);
    Route::put('invoices/{id}', [InvoiceController::class, 'update']);
    Route::delete('invoices/{id}', [InvoiceController::class, 'destroy']);
    Route::post('statsinvoices', [InvoiceController::class, 'statistiquesInvoices']);
    Route::post('statsinvoicespartype', [InvoiceController::class, 'statistiquesInvoicesParType']);
    Route::post('statspermonth', [InvoiceController::class, 'statistiquesParMois']);

    Route::post('transactionsall', [TransactionController::class, 'index']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);

    Route::post('cyclesall', [CycleController::class, 'index']);
    Route::get('cycles/{id}', [CycleController::class, 'show']);
    Route::post('cycles', [CycleController::class, 'store']);
    Route::put('cycles/{id}', [CycleController::class, 'update']);
    Route::delete('cycles/{id}', [CycleController::class, 'destroy']);
    Route::post('cycles/trash', [CycleController::class, 'trashBulk']);
    Route::post('cycles/restore', [CycleController::class, 'restoreBulk']);
    Route::post('cycles/delete', [CycleController::class, 'destroyBulk']);

    Route::post('levelsall', [LevelController::class, 'index']);
    Route::get('levels/{id}', [LevelController::class, 'show']);
    Route::post('levels', [LevelController::class, 'store']);
    Route::put('levels/{id}', [LevelController::class, 'update']);
    Route::delete('levels/{id}', [LevelController::class, 'destroy']);
    Route::post('levels/trash', [LevelController::class, 'trashBulk']);
    Route::post('levels/restore', [LevelController::class, 'restoreBulk']);
    Route::post('levels/delete', [LevelController::class, 'destroyBulk']);

    Route::post('optionlevelsall', [OptionLevelController::class, 'index']);
    Route::get('optionlevels/{id}', [OptionLevelController::class, 'show']);
    Route::post('optionlevels', [OptionLevelController::class, 'store']);
    Route::put('optionlevels/{id}', [OptionLevelController::class, 'update']);
    Route::delete('optionlevels/{id}', [OptionLevelController::class, 'destroy']);
    Route::post('optionlevels/trash', [OptionLevelController::class, 'trashBulk']);
    Route::post('optionlevels/restore', [OptionLevelController::class, 'restoreBulk']);
    Route::post('optionlevels/delete', [OptionLevelController::class, 'destroyBulk']);

    Route::post('classesall', [ClassesController::class, 'index']);
    Route::get('classes/{id}', [ClassesController::class, 'show']);
    Route::post('classes', [ClassesController::class, 'store']);
    Route::put('classes/{id}', [ClassesController::class, 'update']);
    Route::delete('classes/{id}', [ClassesController::class, 'destroy']);
    Route::post('classes/statistics', [ClassesController::class, 'statisticsByClass']);
    Route::post('classes/trash', [ClassesController::class, 'trashBulk']);
    Route::post('classes/restore', [ClassesController::class, 'restoreBulk']);
    Route::post('classes/delete', [ClassesController::class, 'destroyBulk']);

    Route::post('mattersall', [MatterController::class, 'index']);
    Route::get('matters/{id}', [MatterController::class, 'show']);
    Route::post('matters', [MatterController::class, 'store']);
    Route::post('mattersduplicate', [MatterController::class, 'duplicateMatter']);
    Route::put('matters/{id}', [MatterController::class, 'update']);
    Route::delete('matters/{id}', [MatterController::class, 'destroy']);
    Route::post('matters/trash', [MatterController::class, 'trashBulk']);
    Route::post('matters/restore', [MatterController::class, 'restoreBulk']);
    Route::post('matters/delete', [MatterController::class, 'destroyBulk']);

    Route::post('mattergroupsall', [MatterGroupController::class, 'index']);
    Route::get('mattergroups/{id}', [MatterGroupController::class, 'show']);
    Route::post('mattergroups', [MatterGroupController::class, 'store']);
    Route::put('mattergroups/{id}', [MatterGroupController::class, 'update']);
    Route::delete('mattergroups/{id}', [MatterGroupController::class, 'destroy']);
    Route::post('mattergroups/trash', [MatterGroupController::class, 'trashBulk']);
    Route::post('mattergroups/restore', [MatterGroupController::class, 'restoreBulk']);
    Route::post('mattergroups/delete', [MatterGroupController::class, 'destroyBulk']);

    Route::post('coefficientsall', [CoefficientController::class, 'index']);
    Route::get('coefficients/{id}', [CoefficientController::class, 'show']);
    Route::post('coefficients', [CoefficientController::class, 'store']);
    Route::put('coefficients/{id}', [CoefficientController::class, 'update']);
    Route::delete('coefficients/{id}', [CoefficientController::class, 'destroy']);

    Route::post('coursesall', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::post('coursesduplicate', [CourseController::class, 'duplicateCours']);
    Route::post('courses-bulk', [CourseController::class, 'storeBulk']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);
    Route::post('courses/delete', [CourseController::class, 'forceDelete']);
    Route::post('courses/trash', [CourseController::class, 'trash']);
    Route::post('courses/restore', [CourseController::class, 'restore']);

    Route::post('assessmentsall', [AssessmentController::class, 'index']);
    Route::get('assessments/{id}', [AssessmentController::class, 'show']);
    Route::post('assessments', [AssessmentController::class, 'store']);
    Route::post('assessmentsduplicate', [AssessmentController::class, 'duplicateAssessment']);
    Route::put('assessments/{id}', [AssessmentController::class, 'update']);
    Route::delete('assessments/{id}', [AssessmentController::class, 'destroy']);
    Route::post('assessments/delete', [AssessmentController::class, 'destroyBulk']);

    Route::post('progressionsall', [ProgressionController::class, 'index']);
    Route::post('progressionsduplicate', [ProgressionController::class, 'duplicateProgression']);
    Route::get('progressions/{id}', [ProgressionController::class, 'show']);
    Route::post('progressions', [ProgressionController::class, 'store']);
    Route::post('progressionsdetails', [ProgressionController::class, 'getcahiertexte']);
    Route::post('teachermatters', [ProgressionController::class, 'getmatterteacher']);
    Route::put('progressions/{id}', [ProgressionController::class, 'update']);
    Route::delete('progressions/{id}', [ProgressionController::class, 'destroy']);
    Route::post('progressions/trash', [ProgressionController::class, 'trashBulk']);
    Route::post('progressions/restore', [ProgressionController::class, 'restoreBulk']);
    Route::post('progressions/delete', [ProgressionController::class, 'destroyBulk']);

    Route::post('modulesall', [ModuleController::class, 'index']);
    Route::get('modules/{id}', [ModuleController::class, 'show']);
    Route::post('modules', [ModuleController::class, 'store']);
    Route::put('modules/{id}', [ModuleController::class, 'update']);
    Route::delete('modules/{id}', [ModuleController::class, 'destroy']);

    Route::post('chaptersall', [ChapterController::class, 'index']);
    Route::get('chapters/{id}', [ChapterController::class, 'show']);
    Route::post('chapters', [ChapterController::class, 'store']);
    Route::put('chapters/{id}', [ChapterController::class, 'update']);
    Route::delete('chapters/{id}', [ChapterController::class, 'destroy']);

    Route::post('lessonsall', [LessonController::class, 'index']);
    Route::get('lessons/{id}', [LessonController::class, 'show']);
    Route::post('lessons', [LessonController::class, 'store']);
    Route::put('lessons/{id}', [LessonController::class, 'update']);
    Route::delete('lessons/{id}', [LessonController::class, 'destroy']);

    Route::post('topicsall', [TopicController::class, 'index']);
    Route::get('topics/{id}', [TopicController::class, 'show']);
    Route::post('topics', [TopicController::class, 'store']);
    Route::put('topics/{id}', [TopicController::class, 'update']);
    Route::delete('topics/{id}', [TopicController::class, 'destroy']);

    Route::post('ratingsall', [RatingController::class, 'index']);
    Route::get('ratings/{id}', [RatingController::class, 'show']);
    Route::post('ratings', [RatingController::class, 'store']);
    Route::put('ratings/{id}', [RatingController::class, 'update']);
    Route::delete('ratings/{id}', [RatingController::class, 'destroy']);
//    Route::delete('ratings', [RatingController::class,'delete']);
    Route::post('ratings/bulk-delete', [RatingController::class, 'deleteInBulk']);
    Route::post('bulletin', [RatingController::class, 'bulletin']);
    Route::post('bulletinsecondaire', [RatingController::class, 'bulletinsecondaire']);
    Route::post('bulletinsecondairefrancophone', [RatingController::class, 'bulletinSecondaireFrancophone'])->name('bulletinsecondairefrancophone');
    Route::post('bulletinmaternelle', [RatingController::class, 'bulletinmaternelle']);
//    Route::post('generer-bulletin-maternelle', [RatingController::class,'bulletinmaternellePDF']);
    Route::post('genererbulletinsecondairebulk', [RatingController::class, 'genererZipBulletinsSecondaireFrancophone']);
    Route::post('genererbulletinsecondairepersonnel', [RatingController::class, 'genererBulletinsSecondaireFrancophonePersonnel']);

    Route::post('generer-bulletin-maternelle-sequence', [BulletinMaternelleController::class, 'genererBulletinMaternelleSequence']);
    Route::post('generer-bulletin-maternelle-trimestre', [BulletinMaternelleController::class, 'genererBulletinMaternelleTrimestre']);
    Route::post('generer-bulletin-primaire-sequence', [BulletinPrimaireController::class, 'genererBulletinPrimaireSequence']);
    Route::post('generer-bulletin-primaire-trimestre', [BulletinPrimaireController::class, 'genererBulletinPrimaireTrimestre']);
//    Route::post('generer-bulletin-maternelle-primaire', [BulletinPrimaireController::class,'genererBulletinPrimaire']);
    Route::post('generer-bulletin-primaire-trimestre-new', [BulletinPrimaireController::class, 'genererBulletinPrimaireTrimestreNew']); // seq,trim,annuel
    Route::post('generer-bulletin-secondaire-sequence', [BulletinSecondaireController::class, 'genererBulletinSecondaireSequence']);
//    Route::post('generer-bulletin-primaire-annuel', [BulletinController::class,'genererBulletinPrimaireAnnuel']);
//    Route::post('generer-bulletin-secondaire-annuel', [BulletinSecondaireController::class,'genererBulletinSecondaireAnnuel']);
//    Route::post('generer-bulletin-maternelle-classique', [BulletinMaternelleController::class,'genererBulletinMaternelleClassique']); //TODO: le rendu n'est pas terminé
    Route::post('afficher-notes-maternelle-primaire', [BulletinPrimaireController::class, 'afficherNotesPrimaire']);
    Route::post('afficher-notes-secondaire', [BulletinSecondaireController::class, 'afficherNotesSecondaire']);
    //Routes fonctionnelles pour les bulletins
    Route::post('generer-bulletin-maternelle-primaire', [BulletinPrimaireController::class, 'genererBulletinPrimaireSmart']);
    Route::post('generer-bulletin-secondaire', [BulletinSecondaireController::class, 'genererBulletinSecondaireSmart']);

    Route::post('generer-bulletin-test', [BulletinPrimaireController::class, 'genererBulletinPrimaireSmart2']);
    Route::post('statistiques-annuelles-maternelle-primaire', [BulletinPrimaireController::class, 'statistiquesAnnuelles']);

    Route::post('homeworksall', [HomeworkController::class, 'index']);
    Route::get('homeworks/{id}', [HomeworkController::class, 'show']);
    Route::post('homeworks', [HomeworkController::class, 'store']);
    Route::put('homeworks/{id}', [HomeworkController::class, 'update']);
    Route::delete('homeworks/{id}', [HomeworkController::class, 'destroy']);

    Route::post('pensionsall', [PensionController::class, 'index']);
    Route::get('pensions/{id}', [PensionController::class, 'show']);
    Route::post('pensions', [PensionController::class, 'store']);
    Route::put('pensions/{id}', [PensionController::class, 'update']);
    Route::delete('pensions/{id}', [PensionController::class, 'destroy']);

    Route::post('feesall', [FeeController::class, 'index']);
    Route::get('fees/{id}', [FeeController::class, 'show']);
    Route::post('fees', [FeeController::class, 'store']);
    Route::put('fees/{id}', [FeeController::class, 'update']);
    Route::delete('fees/{id}', [FeeController::class, 'destroy']);
//
    Route::post('feeusersall', [FeeUserController::class, 'index']);
    Route::post('feeusersallarchives', [FeeUserController::class, 'indexArchives']);
    Route::get('feeusers/{id}', [FeeUserController::class, 'show']);
    Route::get('feeuserspdf/{id}', [FeeUserController::class, 'getpdf']);
    Route::post('feeusers', [FeeUserController::class, 'store']);
    Route::post('feeusers/archive-restore', [FeeUserController::class, 'archiveOrRestore']);
    Route::post('feeusersstorepdf', [FeeUserController::class, 'storepdf']);
    Route::post('balancefee', [FeeUserController::class, 'balancefee']);
    Route::delete('feeusers/{id}', [FeeUserController::class, 'destroy']);
    Route::post('feeusers-{type}', [FeeUserController::class, 'solvablesOuInsolvables'])->where('type', 'solvables|insolvables');

    Route::post('tranchesall', [TrancheController::class, 'index']);
    Route::get('tranches/{id}', [TrancheController::class, 'show']);
    Route::post('tranches', [TrancheController::class, 'store']);
//    Route::post('tranches-bulk', [TrancheController::class,'bulkStore']);
    Route::put('tranches/{id}', [TrancheController::class, 'update']);
    Route::delete('tranches/{id}', [TrancheController::class, 'destroy']);

    Route::post('schoolFoldersall', [SchoolFolderController::class, 'index']);
    Route::get('schoolFolders/{id}', [SchoolFolderController::class, 'show']);
    Route::post('schoolFolders', [SchoolFolderController::class, 'store']);
    Route::put('schoolFolders/{id}', [SchoolFolderController::class, 'update']);
    Route::delete('schoolFolders/{id}', [SchoolFolderController::class, 'destroy']);

    // On continue ici
    Route::post('pensionUsersall', [PensionUserController::class, 'index']);
    Route::post('pensionUsersallarchives', [PensionUserController::class, 'indexArchives']);
    Route::get('pensionUsers/{id}', [PensionUserController::class, 'show']);
    Route::get('pensionuserspdf/{id}', [PensionUserController::class, 'getpdf']);
    Route::post('pensionUsers', [PensionUserController::class, 'store']);
    Route::post('pensionusersstorepdf', [PensionUserController::class, 'storepdf']);
    Route::post('balancePension', [PensionUserController::class, 'balancePension']);
    Route::post('balancePensionWithBourse', [PensionUserController::class, 'balancePensionWithBourse']);
    Route::delete('pensionUsers/{id}', [PensionUserController::class, 'destroy']);
    Route::post('pensionUsers/archive-restore', [PensionUserController::class, 'archiveOrRestore']);
    Route::post('pensionUsersinsolvable', [PensionUserController::class, 'insolvable']);
    Route::post('pensionUsersSolvable', [PensionUserController::class, 'solvables']);
    Route::post('pensionuserssum', [PensionUserController::class, 'getsumtransaction']);
    Route::post('student-pension-summary', [PensionUserController::class, 'getStudentPensionSummary']);

    Route::post('schoolsuppliesall', [SchoolSupplyController::class, 'index']);
    Route::get('schoolsupplies/{id}', [SchoolSupplyController::class, 'show']);
    Route::post('schoolsupplies', [SchoolSupplyController::class, 'store']);
    Route::put('schoolsupplies/{id}', [SchoolSupplyController::class, 'update']);
    Route::delete('schoolsupplies/{id}', [SchoolSupplyController::class, 'destroy']);

    Route::post('teacherobservationsall', [TeacherObservationController::class, 'index']);
    Route::get('teacherobservations/{id}', [TeacherObservationController::class, 'show']);
    Route::post('teacherobservations', [TeacherObservationController::class, 'store']);
    Route::put('teacherobservations/{id}', [TeacherObservationController::class, 'update']);
    Route::delete('teacherobservations/{id}', [TeacherObservationController::class, 'destroy']);

    Route::post('parentalmonitoringsall', [ParentalMonitoringController::class, 'index']);
    Route::get('parentalmonitorings/{id}', [ParentalMonitoringController::class, 'show']);
    Route::post('parentalmonitorings', [ParentalMonitoringController::class, 'store']);
    Route::put('parentalmonitorings/{id}', [ParentalMonitoringController::class, 'update']);
    Route::delete('parentalmonitorings/{id}', [ParentalMonitoringController::class, 'destroy']);

    Route::post('eventsall', [EventController::class, 'index']);
    Route::get('events/{id}', [EventController::class, 'show']);
    Route::post('events', [EventController::class, 'store']);
    Route::put('events/{id}', [EventController::class, 'update']);
    Route::delete('events/{id}', [EventController::class, 'destroy']);
    Route::post('events/trash', [EventController::class, 'trash']);
    Route::post('events/restore', [EventController::class, 'restore']);

    Route::post('absencesall', [AbsencesController::class, 'index']);
    Route::get('absences/{id}', [AbsencesController::class, 'show']);
    Route::post('absences', [AbsencesController::class, 'store']);
    Route::put('absences/{id}', [AbsencesController::class, 'update']);
    Route::delete('absences/{id}', [AbsencesController::class, 'destroy']);
    Route::post('absences/trash', [AbsencesController::class, 'trash']);
    Route::post('absences/restore', [AbsencesController::class, 'restore']);
    Route::post('absences/delete', [AbsencesController::class, 'destroyBulk']);

    Route::post('sanctionsall', [SanctionController::class, 'index']);
    Route::get('sanctions/{id}', [SanctionController::class, 'show']);
    Route::post('sanctions', [SanctionController::class, 'store']);
    Route::put('sanctions/{id}', [SanctionController::class, 'update']);
    Route::delete('sanctions/{id}', [SanctionController::class, 'destroy']);
    Route::post('sanctions/trash', [SanctionController::class, 'trashBulk']);
    Route::post('sanctions/restore', [SanctionController::class, 'restoreBulk']);
    Route::post('sanctions/delete', [SanctionController::class, 'destroyBulk']);

    Route::post('homeworkdonesall', [HomeworkDoneController::class, 'index']);
    Route::get('homeworkdones/{id}', [HomeworkDoneController::class, 'show']);
    Route::post('homeworkdones', [HomeworkDoneController::class, 'store']);
    Route::post('homeworkdones/download', [HomeworkDoneController::class, 'download']);
    Route::put('homeworkdones/{id}', [HomeworkDoneController::class, 'update']);
    Route::delete('homeworkdones/{id}', [HomeworkDoneController::class, 'destroy']);

    Route::post('tasksall', [TaskController::class, 'index']);
    Route::get('tasks/{id}', [TaskController::class, 'show']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('tasks/{id}', [TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);

    Route::post('assessmenttypesall', [AssessmentTypeController::class, 'index']);
    Route::get('assessmenttypes/{id}', [AssessmentTypeController::class, 'show']);
    Route::post('assessmenttypes', [AssessmentTypeController::class, 'store']);
    Route::put('assessmenttypes/{id}', [AssessmentTypeController::class, 'update']);
    Route::delete('assessmenttypes/{id}', [AssessmentTypeController::class, 'destroy']);
    Route::post('assessmenttypes/trash', [AssessmentTypeController::class, 'trashBulk']);
    Route::post('assessmenttypes/restore', [AssessmentTypeController::class, 'restoreBulk']);
    Route::post('assessmenttypes/delete', [AssessmentTypeController::class, 'destroyBulk']);

    Route::post('presenceteachersall', [PresenceTeacherController::class, 'index']);
    Route::get('presenceteachers/{id}', [PresenceTeacherController::class, 'show']);
    Route::post('presenceteachers', [PresenceTeacherController::class, 'store']);
    Route::post('qrcodepresence', [QRCodeController::class, 'storePresenceTeacherByQRCode']);
    Route::put('presenceteachers/{id}', [PresenceTeacherController::class, 'update']);
    Route::delete('presenceteachers/{id}', [PresenceTeacherController::class, 'destroy']);
    Route::post('calcultauxhoraire', [PresenceTeacherController::class, 'calcultauxhoraire']);
    Route::post('presenceteachers/trash', [PresenceTeacherController::class, 'trash']);
    Route::post('presenceteachers/restore', [PresenceTeacherController::class, 'restore']);
    Route::post('presenceteachers/delete', [PresenceTeacherController::class, 'destroyBulk']);

    Route::post('keys', [KeyController::class, 'store']);
    Route::get('keys/{id}', [KeyController::class, 'show']);
    Route::get('keysall', [KeyController::class, 'index']);
    Route::put('keys/{id}', [KeyController::class, 'update']);
    Route::delete('keys/{id}', [KeyController::class, 'destroy']);

    Route::post('typeevaluations', [TypeEvaluationController::class, 'store']);
    Route::get('typeevaluations/{id}', [TypeEvaluationController::class, 'show']);
    Route::post('typeevaluationsall', [TypeEvaluationController::class, 'index']);
    Route::put('typeevaluations/{id}', [TypeEvaluationController::class, 'update']);
    Route::delete('typeevaluations/{id}', [TypeEvaluationController::class, 'destroy']);
    Route::post('typeevaluations/trash', [TypeEvaluationController::class, 'trashBulk']);
    Route::post('typeevaluations/restore', [TypeEvaluationController::class, 'restoreBulk']);
    Route::post('typeevaluations/delete', [TypeEvaluationController::class, 'destroyBulk']);

    Route::post('trimestres', [TrimestreController::class, 'store']);
    Route::get('trimestres/{id}', [TrimestreController::class, 'show']);
    Route::post('trimestresall', [TrimestreController::class, 'index']);
    Route::put('trimestres/{id}', [TrimestreController::class, 'update']);
    Route::delete('trimestres/{id}', [TrimestreController::class, 'destroy']);
    Route::post('trimestres/trash', [TrimestreController::class, 'trashBulk']);
    Route::post('trimestres/restore', [TrimestreController::class, 'restoreBulk']);
    Route::post('trimestres/delete', [TrimestreController::class, 'destroyBulk']);

    Route::post('generate-qr-code', [QRCodeController::class, 'generateQRCode']);

    Route::post("notifications", [NotificationController::class, 'index']);

    Route::post('customersall', [CustomerController::class, "index"]);
    Route::get('customers/{id}', [CustomerController::class, "show"]);
    Route::post('customers', [CustomerController::class, "store"]);
    Route::put('customers/{id}', [CustomerController::class, "update"]);
    Route::delete('customers/{id}', [CustomerController::class, "destroy"]);

    Route::post('boursesall', [BourseController::class, "index"]);
    Route::get('bourses/{id}', [BourseController::class, "show"]);
    Route::post('bourses', [BourseController::class, "store"]);
    Route::put('bourses/{id}', [BourseController::class, "update"]);
    Route::delete('bourses/{id}', [BourseController::class, "destroy"]);

    Route::post('filieresall', [FiliereController::class, "index"]);
    Route::get('filieres/{id}', [FiliereController::class, "show"]);
    Route::post('filieres', [FiliereController::class, "store"]);
    Route::put('filieres/{id}', [FiliereController::class, "update"]);
    Route::delete('filieres/{id}', [FiliereController::class, "destroy"]);

    Route::post('requetesall', [RequeteController::class, "index"]);
    Route::get('requetes/{id}', [RequeteController::class, "show"]);
    Route::post('requetes', [RequeteController::class, "store"]);
    Route::put('requetes/{id}', [RequeteController::class, "update"]);
    Route::delete('requetes/{id}', [RequeteController::class, "destroy"]);
    Route::post('requetes/trash', [RequeteController::class, "trash"]);
    Route::post('requetes/restore', [RequeteController::class, "restore"]);
    Route::post('requetes/delete', [RequeteController::class, "destroyBulk"]);

    Route::post('typeinvoicesall', [TypeInvoiceController::class, "index"]);
    Route::get('typeinvoices/{id}', [TypeInvoiceController::class, "show"]);
    Route::post('typeinvoices', [TypeInvoiceController::class, "store"]);
    Route::put('typeinvoices/{id}', [TypeInvoiceController::class, "update"]);
    Route::delete('typeinvoices/{id}', [TypeInvoiceController::class, "destroy"]);
    Route::post('typeinvoices/trash', [TypeInvoiceController::class, "trash"]);
    Route::post('typeinvoices/restore', [TypeInvoiceController::class, "restore"]);
    Route::post('typeinvoices/delete', [TypeInvoiceController::class, "destroyBulk"]);

    Route::post('typerequetesall', [TypeRequeteController::class, "index"]);
    Route::get('typerequetes/{id}', [TypeRequeteController::class, "show"]);
    Route::post('typerequetes', [TypeRequeteController::class, "store"]);
    Route::put('typerequetes/{id}', [TypeRequeteController::class, "update"]);
    Route::delete('typerequetes/{id}', [TypeRequeteController::class, "destroy"]);
    Route::post('typerequetes/trash', [TypeRequeteController::class, 'trashBulk']);
    Route::post('typerequetes/restore', [TypeRequeteController::class, 'restoreBulk']);
    Route::post('typerequetes/delete', [TypeRequeteController::class, 'destroyBulk']);

    Route::post('moyenne-student', [MoyenneController::class, 'moyenneParSequence']);

    Route::post('booksall', [BookController::class, "index"]);
    Route::get('books/{id}', [BookController::class, "show"]);
    Route::post('books', [BookController::class, "store"]);
    Route::put('books/{id}', [BookController::class, "update"]);
    Route::delete('books/{id}', [BookController::class, "destroy"]);
    Route::post('books/trash', [BookController::class, 'trashBulk']);
    Route::post('books/restore', [BookController::class, 'restoreBulk']);
    Route::post('books/delete', [BookController::class, 'destroyBulk']);

    Route::post('locationsall', [LocationController::class, "index"]);
    Route::get('locations/{id}', [LocationController::class, "show"]);
    Route::post('locations', [LocationController::class, "store"]);
    Route::put('locations/{id}', [LocationController::class, "update"]);
    Route::delete('locations/{id}', [LocationController::class, "destroy"]);
    Route::post('locations/trash', [LocationController::class, 'trashBulk']);
    Route::post('locations/restore', [LocationController::class, 'restoreBulk']);
    Route::post('locations/delete', [LocationController::class, 'destroyBulk']);

    Route::group(['prefix' => "documents"], function () {
        Route::post('list-students', [DocumentController::class, 'listStudentsPDF']);
        Route::post('list-parents', [DocumentController::class, 'listParentsPDF']);
        Route::post('list-pensions-users', [DocumentController::class, 'listPensionUsersPDF']);
        Route::post('list-fees-users', [DocumentController::class, 'listFeeUsersPDF']);
        Route::post('list-teachers', [DocumentController::class, 'listTeachersPDF']);
        Route::post('list-staff', [DocumentController::class, 'listStaffPDF']);
        Route::post('list-customers', [DocumentController::class, 'listCustomers']);
        Route::post('list-invoices', [DocumentController::class, 'listInvoices']);
        Route::post('list-users-assessments', [DocumentController::class, 'listUsersWithAssessments']);
        Route::post('list-users-assessments-by-matter', [DocumentController::class, 'listUsersWithAssessmentsByMatter']);
        Route::post('list-users-assessments-by-matter-group', [DocumentController::class, 'listUsersWithAssessmentsByMatterGroup']);

        Route::post('pv-primaire-sequence', [BulletinPrimaireController::class, 'pvPrimaireSequence']);
        Route::post('pv-primaire-trimestre-sequentiel', [BulletinPrimaireController::class, 'pvPrimaireTrimestreOuSequentielle']);
        Route::post('pv-secondaire', [BulletinSecondaireController::class, 'genererPvSecondaire']);
        // Route::post('pv-secondaire', [BulletinSecondaireController::class, 'pvSecondaire']);

        Route::post('list-{category}', [DocumentController::class, 'listSolvablesPDF'])->where(['category' => 'solvables|insolvables']);
        Route::post('list-pdf-{type}-feeusers', [DocumentController::class, 'listInsolvablesOuSolvablesPDF'])->where('type', 'solvables|insolvables');

        Route::post('certificat-transfert', [CertificatDeTransfertController::class, 'certificatTransfert']);
        Route::post('infos-generales-ecole', [InfosEcoleController::class, 'infosTrimestre']);

        Route::post('list-student-answers-on-assessment', [PropositionQuestionController::class, 'listStudentAnswersOnAssessment']);

        Route::post('generer-tableau-honneur', [DocumentController::class, 'genererTableauHonneur']);
    });

    Route::post('projectsall', [ProjectController::class, "index"]);
    Route::post('projects', [ProjectController::class, "store"]);
    Route::post('projects-bulk', [ProjectController::class, "bulkStore"]);
    Route::get('projects/{id}', [ProjectController::class, "show"]);
    Route::put('projects/{id}', [ProjectController::class, "update"]);
    Route::delete('projects/trash/{id}', [ProjectController::class, "trash"]);
    Route::post('projects/restore/{id}', [ProjectController::class, "restore"]);
//    Route::delete('projects/delete/{id}', [ProjectController::class, "destroy"]);

    Route::post('reglements-interieursall', [ReglementInterieurController::class, "index"]);
    Route::post('reglements-interieurs', [ReglementInterieurController::class, "store"]);
    Route::get('reglements-interieurs/{id}', [ReglementInterieurController::class, "show"]);
    Route::put('reglements-interieurs/{id}', [ReglementInterieurController::class, "update"]);
    Route::delete('reglements-interieurs/trash/{id}', [ReglementInterieurController::class, "trash"]);
    Route::post('reglements-interieurs/restore/{id}', [ReglementInterieurController::class, "restore"]);
//    Route::delete('reglements-interieurs/delete/{id}', [ReglementInterieurController::class, "destroy"]);

    Route::post('transfertsall', [CertificatDeTransfertController::class, 'index']);
    Route::get('transferts/{id}', [CertificatDeTransfertController::class, "show"]);

    Route::post('note-fraisall', [NoteFraisController::class, "index"]);
    Route::post('note-frais', [NoteFraisController::class, "store"]);
    Route::get('note-frais/{id}', [NoteFraisController::class, "show"]);
    Route::put('note-frais/{id}', [NoteFraisController::class, "update"]);
    Route::delete('note-frais/trash/{id}', [NoteFraisController::class, "trash"]);
    Route::post('note-frais/restore/{id}', [NoteFraisController::class, "restore"]);
    Route::post('note-frais/download', [NoteFraisController::class, "download"]);

    Route::post('logsall', [LogController::class, "index"]);
    Route::post('logs', [LogController::class, "store"]);
    Route::get('logs/{id}', [LogController::class, "show"]);

    Route::post('pages-livresall', [PageLivreController::class, "index"]);
    Route::post('pages-livres', [PageLivreController::class, "store"]);
    Route::get('pages-livres/{id}', [PageLivreController::class, "show"]);
    Route::put('pages-livres/{id}', [PageLivreController::class, "update"]);
    Route::delete('pages-livres/trash/{id}', [PageLivreController::class, "trash"]);
    Route::post('pages-livres/restore/{id}', [PageLivreController::class, "restore"]);
//    Route::delete('reglements-interieurs/delete/{id}', [ReglementInterieurController::class, "destroy"]);

    Route::post('examsall', [ExamStudentController::class, "index"]);
    Route::post('exams', [ExamStudentController::class, "store"]);
    Route::get('exams/{id}', [ExamStudentController::class, "show"]);
    Route::put('exams/{id}', [ExamStudentController::class, "update"]);
    Route::delete('exams/trash/{id}', [ExamStudentController::class, "trash"]);
    Route::post('exams/restore/{id}', [ExamStudentController::class, "restore"]);

    Route::post('questionnairesall', [QuestionnaireController::class, "index"]);
    Route::post('questionnaires', [QuestionnaireController::class, "store"]);
    Route::get('questionnaires/{id}', [QuestionnaireController::class, "show"]);
    Route::put('questionnaires/{id}', [QuestionnaireController::class, "update"]);
    Route::delete('questionnaires/trash/{id}', [QuestionnaireController::class, "trash"]);
    Route::post('questionnaires/restore/{id}', [QuestionnaireController::class, "restore"]);

    Route::post('propositions-questionnairesall', [PropositionQuestionController::class, "index"]);
    Route::post('propositions-questionnaires', [PropositionQuestionController::class, "store"]);
    Route::get('propositions-questionnaires/{id}', [PropositionQuestionController::class, "show"]);
    Route::put('propositions-questionnaires/{id}', [PropositionQuestionController::class, "update"]);
    Route::delete('propositions-questionnaires/trash/{id}', [PropositionQuestionController::class, "trash"]);
    Route::post('propositions-questionnaires/restore/{id}', [PropositionQuestionController::class, "restore"]);

    Route::post('responses/all', [ResponseStudentController::class, "index"]);
    Route::post('responses', [ResponseStudentController::class, "store"]);
    Route::put('responses/{id}', [ResponseStudentController::class, "update"]);
    Route::delete('responses/trash/{id}', [ResponseStudentController::class, "trash"]);
    Route::post('responses/restore/{id}', [ResponseStudentController::class, "restore"]);

    Route::group(['prefix' => "mark-exam-online"], function () {
        Route::post('get-student-responses', [MarkOnlineExamController::class, "getStudentResponses"]); // récupérer les réponses d'un étudiant pour que l'enseignant les corrige
        Route::post('set-student-notes', [MarkOnlineExamController::class, "setStudentNotes"]); // noter les réponses d'un étudiant
    });

    Route::post('clientsall', [ClientController::class, "index"]);
    Route::post('clients', [ClientController::class, "store"]);
    Route::get('clients/{id}', [ClientController::class, "show"]);
    Route::put('clients/{id}', [ClientController::class, "update"]);
    Route::delete('clients/trash/{id}', [ClientController::class, "trash"]);
    Route::post('clients/restore/{id}', [ClientController::class, "restore"]);

    Route::post('cashinsall', [CashInController::class, "index"]);
    Route::post('cashins', [CashInController::class, "store"]);
    Route::get('cashins/{id}', [CashInController::class, "show"]);
    Route::put('cashins/{id}', [CashInController::class, "update"]);
    Route::delete('cashins/trash/{id}', [CashInController::class, "trash"]);
    Route::post('cashins/restore/{id}', [CashInController::class, "restore"]);
    Route::post('cashins/trash', [CashInController::class, "trashBulk"]);
    Route::post('cashins/restore', [CashInController::class, "restoreBulk"]);
    Route::post('cashins/delete', [CashInController::class, "destroyBulk"]);

    Route::post('extracashinsall', [ExtraCashinsController::class, "index"]);
    Route::post('extracashins', [ExtraCashinsController::class, "store"]);
    Route::get('extracashins/{id}', [ExtraCashinsController::class, "show"]);
    Route::put('extracashins/{id}', [ExtraCashinsController::class, "update"]);
    Route::delete('extracashins/trash/{id}', [ExtraCashinsController::class, "trash"]);
    Route::post('extracashins/restore/{id}', [ExtraCashinsController::class, "restore"]);

    Route::group(['prefix' => "sms"], function () {
        Route::post('', [SendSMSController::class, "send"]);
        Route::post('to', [SendSMSController::class, "sendTo"]);
        Route::post('all', [SendSMSController::class, "getAll"]);
        Route::get('balance', [SendSMSController::class, "getBalance"]);
    });

    Route::post("permissions-usersall", [PermissionUserController::class, "index"]);
    Route::post("permissions-users", [PermissionUserController::class, "store"]);
    Route::get("permissions-users/{id}", [PermissionUserController::class, "show"]);
    Route::put("permissions-users/{id}", [PermissionUserController::class, "update"]);
    Route::delete("permissions-users/trash/{id}", [PermissionUserController::class, "trash"]);
    Route::post("permissions-users/restore/{id}", [PermissionUserController::class, "restore"]);
    Route::delete("permissions-users/delete/{id}", [PermissionUserController::class, "destroy"]);

    Route::post("productsall", [ProductController::class, "index"]);
    Route::post("products", [ProductController::class, "store"]);
    Route::get("products/{id}", [ProductController::class, "show"]);
    Route::put("products/{id}", [ProductController::class, "update"]);
    Route::post("products/trash", [ProductController::class, "trash"]);
    Route::post("products/restore", [ProductController::class, "restore"]);
    Route::post("products/delete", [ProductController::class, "destroy"]);

    //Route::get("student-solvency/{id}", [UserController::class, "solvency"]);
    Route::post("student-solvency", [UserController::class, "solvency"]);

    Route::post("warningsall", [WarningController::class, "index"]);
    Route::post("warnings", [WarningController::class, "store"]);
    Route::get("warnings/{warning}", [WarningController::class, "show"]);
    Route::put("warnings/{warning}", [WarningController::class, "update"]);
    Route::post("warnings/trash", [WarningController::class, "trash"]);
    Route::post("warnings/restore", [WarningController::class, "restore"]);
    Route::post("warnings/delete", [WarningController::class, "destroy"]);

    Route::post("contractsall", [ContractController::class, "index"]);
    Route::post("contracts", [ContractController::class, "create"]);
    Route::post("contracts/upload", [ContractController::class, "upload"]);
    Route::get("contracts/{id}", [ContractController::class, "show"]);
    Route::put("contracts/{id}", [ContractController::class, "update"]);
    Route::post("contracts/trash", [ContractController::class, "trash"]);
    Route::post("contracts/restore", [ContractController::class, "restore"]);
    Route::post("contracts/delete", [ContractController::class, "destroy"]);

    Route::post("salaries-deductionsall", [SalaryDeductionController::class, "index"]);
    Route::post("salaries-deductions", [SalaryDeductionController::class, "store"]);
    Route::get("salaries-deductions/{salary_deduction}", [SalaryDeductionController::class, "show"]);
    Route::put("salaries-deductions/{salary_deduction}", [SalaryDeductionController::class, "update"]);
    Route::post("salaries-deductions/trash", [SalaryDeductionController::class, "trash"]);
    Route::post("salaries-deductions/restore", [SalaryDeductionController::class, "restore"]);
    Route::post("salaries-deductions/delete", [SalaryDeductionController::class, "destroy"]);

    Route::post("holidaysall", [HolidayController::class, "index"]);
    Route::post("holidays", [HolidayController::class, "store"]);
    Route::get("holidays/{holiday}", [HolidayController::class, "show"]);
    Route::put("holidays/{holiday}", [HolidayController::class, "update"]);
    Route::post("holidays/trash", [HolidayController::class, "trash"]);
    Route::post("holidays/restore", [HolidayController::class, "restore"]);
    Route::post("holidays/delete", [HolidayController::class, "destroy"]);

    Route::post("bonusesall", [BonusController::class, "index"]);
    Route::post("bonuses", [BonusController::class, "store"]);
    Route::get("bonuses/{bonus}", [BonusController::class, "show"]);
    Route::put("bonuses/{bonus}", [BonusController::class, "update"]);
    Route::post("bonuses/trash", [BonusController::class, "trash"]);
    Route::post("bonuses/restore", [BonusController::class, "restore"]);
    Route::post("bonuses/delete", [BonusController::class, "destroy"]);

    Route::post("lessons-summariesall", [LessonSummaryController::class, "index"]);
    Route::post("lessons-summaries", [LessonSummaryController::class, "store"]);
    Route::get("lessons-summaries/{lesson_summary}", [LessonSummaryController::class, "show"]);
    Route::put("lessons-summaries/{lesson_summary}", [LessonSummaryController::class, "update"]);
    Route::post("lessons-summaries/trash", [LessonSummaryController::class, "trash"]);
    Route::post("lessons-summaries/restore", [LessonSummaryController::class, "restore"]);
    Route::post("lessons-summaries/delete", [LessonSummaryController::class, "destroy"]);
    Route::post("lessons-summaries/download", [LessonSummaryController::class, "download"]);

    Route::post("salary-advancesall", [SalaryAdvanceController::class, "index"]);
    Route::post("salary-advances", [SalaryAdvanceController::class, "store"]);
    Route::get("salary-advances/{salary_advance}", [SalaryAdvanceController::class, "show"]);
    Route::put("salary-advances/{salary_advance}", [SalaryAdvanceController::class, "update"]);
    Route::post("salary-advances/trash", [SalaryAdvanceController::class, "trash"]);
    Route::post("salary-advances/restore", [SalaryAdvanceController::class, "restore"]);
    Route::post("salary-advances/delete", [SalaryAdvanceController::class, "destroy"]);

    Route::post("salary-componentsall", [SalaryComponentController::class, "index"]);
    Route::post("salary-components", [SalaryComponentController::class, "store"]);
    Route::get("salary-components/{salary_component}", [SalaryComponentController::class, "show"]);
    Route::put("salary-components/{salary_component}", [SalaryComponentController::class, "update"]);
    Route::post("salary-components/trash", [SalaryComponentController::class, "trash"]);
    Route::post("salary-components/restore", [SalaryComponentController::class, "restore"]);
    Route::post("salary-components/delete", [SalaryComponentController::class, "destroy"]);

    Route::post("moratoriumsall", [MoratoriumController::class, "index"]);
    Route::post("moratoriums", [MoratoriumController::class, "store"]);
    Route::get("moratoriums/{moratorium}", [MoratoriumController::class, "show"]);
    Route::put("moratoriums/{moratorium}", [MoratoriumController::class, "update"]);
    Route::post("moratoriums/trash", [MoratoriumController::class, "trash"]);
    Route::post("moratoriums/restore", [MoratoriumController::class, "restore"]);
    Route::post("moratoriums/delete", [MoratoriumController::class, "destroy"]);

    // Routes pour SchoolExam
    Route::post("schools-examsall", [SchoolExamController::class, "index"]);
    Route::post("schools-exams", [SchoolExamController::class, "store"]);
    Route::get("schools-exams/{school_exam}", [SchoolExamController::class, "show"]);
    Route::put("schools-exams/{school_exam}", [SchoolExamController::class, "update"]);
    Route::post("schools-exams/trash", [SchoolExamController::class, "trash"]);
    Route::post("schools-exams/restore", [SchoolExamController::class, "restore"]);
    Route::post("schools-exams/delete", [SchoolExamController::class, "destroy"]);

    Route::post("scan-receiptsall", [ScanReceiptController::class, "index"]);
    Route::post("scan-receipts", [ScanReceiptController::class, "create"]);
    Route::get("scan-receipts/{scan_receipt}", [ScanReceiptController::class, "show"]);
    Route::put("scan-receipts/{scan_receipt}", [ScanReceiptController::class, "update"]);
    Route::post("scan-receipts/trash", [ScanReceiptController::class, "trash"]);
    Route::post("scan-receipts/restore", [ScanReceiptController::class, "restore"]);
    Route::post("scan-receipts/delete", [ScanReceiptController::class, "destroy"]);

    Route::post("articlesall", [ArticleController::class, "index"]);
    Route::post("articles", [ArticleController::class, "create"]);
    Route::get("articles/{article}", [ArticleController::class, "show"]);
    Route::put("articles/{article}", [ArticleController::class, "update"]);
    Route::post("articles/trash", [ArticleController::class, "trash"]);
    Route::post("articles/restore", [ArticleController::class, "restore"]);
    Route::post("articles/delete", [ArticleController::class, "destroy"]);

    Route::post("article-movementsall", [ArticleMovementController::class, "index"]);
    Route::post("article-movements", [ArticleMovementController::class, "create"]);
    Route::get("article-movements/{article}", [ArticleMovementController::class, "show"]);
    Route::post("article-movements/trash", [ArticleMovementController::class, "trash"]);
    Route::post("article-movements/restore", [ArticleMovementController::class, "restore"]);
    Route::post("article-movements/delete", [ArticleMovementController::class, "destroy"]);

    Route::post("purchase-ordersall", [PurchaseOrderController::class, "index"]);
    Route::post("purchase-orders", [PurchaseOrderController::class, "create"]);
    Route::get("purchase-orders/{purchase_order}", [PurchaseOrderController::class, "show"]);
    Route::put("purchase-orders/{purchase_order}", [PurchaseOrderController::class, "update"]);
    Route::post("purchase-orders/trash", [PurchaseOrderController::class, "trash"]);
    Route::post("purchase-orders/restore", [PurchaseOrderController::class, "restore"]);
    Route::post("purchase-orders/delete", [PurchaseOrderController::class, "destroy"]);

    Route::post("supply-demandsall", [SupplyDemandController::class, "index"]);
    Route::post("supply-demands", [SupplyDemandController::class, "create"]);
    Route::get("supply-demands/{supply_demand}", [SupplyDemandController::class, "show"]);
    Route::put("supply-demands/{supply_demand}", [SupplyDemandController::class, "update"]);
    Route::post("supply-demands/trash", [SupplyDemandController::class, "trash"]);
    Route::post("supply-demands/restore", [SupplyDemandController::class, "restore"]);
    Route::post("supply-demands/delete", [SupplyDemandController::class, "destroy"]);

    Route::post("budgetsall", [BudgetController::class, "index"]);
    Route::post("budgets", [BudgetController::class, "create"]);
    Route::get("budgets/{budget}", [BudgetController::class, "show"]);
    Route::put("budgets/{budget}", [BudgetController::class, "update"]);
    Route::post("budgets/trash", [BudgetController::class, "trash"]);
    Route::post("budgets/restore", [BudgetController::class, "restore"]);
    Route::post("budgets/delete", [BudgetController::class, "destroy"]);
    Route::post("budgets/progress", [BudgetController::class, "progress"]);

    Route::post("type-of-recipesall", [TypeOfRecipeController::class, "index"]);
    Route::post("type-of-recipes", [TypeOfRecipeController::class, "create"]);
    Route::get("type-of-recipes/{type_of_recipe}", [TypeOfRecipeController::class, "show"]);
    Route::put("type-of-recipes/{type_of_recipe}", [TypeOfRecipeController::class, "update"]);
    Route::post("type-of-recipes/trash", [TypeOfRecipeController::class, "trash"]);
    Route::post("type-of-recipes/restore", [TypeOfRecipeController::class, "restore"]);
    Route::post("type-of-recipes/delete", [TypeOfRecipeController::class, "destroy"]);

    Route::post("rentalsall", [RentalController::class, "index"]);
    Route::post("rentals", [RentalController::class, "create"]);
    Route::get("rentals/{rental}", [RentalController::class, "show"]);
    Route::put("rentals/{rental}", [RentalController::class, "update"]);
    Route::post("rentals/trash", [RentalController::class, "trash"]);
    Route::post("rentals/restore", [RentalController::class, "restore"]);
    Route::post("rentals/delete", [RentalController::class, "destroy"]);

    Route::prefix('mtn-payments')->group(function () {
        Route::post('/', [MtnPaymentController::class, 'initiate']);
        Route::post('/hook', [MtnPaymentController::class, 'webhook']);
        Route::get('/{transaction}', [MtnPaymentController::class, 'status']); // optionnelle
        Route::post('/statistics', [MtnPaymentController::class, 'statistics']); // optionnelle
    });

    Route::post("daily-reportsall", [DailyReportController::class, "index"]);
    Route::post("daily-reports", [DailyReportController::class, "create"]);
    Route::get("daily-reports/{dailyReport}", [DailyReportController::class, "show"]);
    Route::put("daily-reports/{dailyReport}", [DailyReportController::class, "update"]);
    Route::post("daily-reports/trash", [DailyReportController::class, "trash"]);
    Route::post("daily-reports/restore", [DailyReportController::class, "restore"]);
    Route::post("daily-reports/delete", [DailyReportController::class, "destroy"]);

    Route::post("suggestionsall", [SuggestionController::class, "index"]);
    Route::post("suggestions", [SuggestionController::class, "create"]);
    Route::get("suggestions/{suggestion}", [SuggestionController::class, "show"]);
    Route::put("suggestions/{suggestion}", [SuggestionController::class, "update"]);
    Route::post("suggestions/trash", [SuggestionController::class, "trash"]);
    Route::post("suggestions/restore", [SuggestionController::class, "restore"]);
    Route::post("suggestions/delete", [SuggestionController::class, "destroy"]);

    Route::post("litigesall", [LitigeController::class, "index"]);
    Route::post("litiges", [LitigeController::class, "store"]);
    Route::get("litiges/{litige}", [LitigeController::class, "show"]);
    Route::put("litiges/{litige}", [LitigeController::class, "update"]);
    Route::post("litiges/trash", [LitigeController::class, "trash"]);
    Route::post("litiges/restore", [LitigeController::class, "restore"]);
    Route::post("litiges/delete", [LitigeController::class, "destroy"]);

    Route::post("transportsall", [TransportController::class, "index"]);
    Route::post("transports", [TransportController::class, "create"]);
    Route::get("transports/{transport}", [TransportController::class, "show"]);
    Route::put("transports/{transport}", [TransportController::class, "update"]);
    Route::post("transports/trash", [TransportController::class, "trash"]);
    Route::post("transports/restore", [TransportController::class, "restore"]);
    Route::post("transports/delete", [TransportController::class, "destroy"]);

    Route::post("transport-usersall", [TransportUserController::class, "index"]);
    Route::post("transport-users", [TransportUserController::class, "create"]);
    Route::get("transport-users/{transport_user}", [TransportUserController::class, "show"]);
    Route::put("transport-users/{transport_user}", [TransportUserController::class, "update"]);
    Route::post("transport-users/trash", [TransportUserController::class, "trash"]);
    Route::post("transport-users/restore", [TransportUserController::class, "restore"]);
    Route::post("transport-users/delete", [TransportUserController::class, "destroy"]);

    Route::post("payment-transport-usersall", [PaymentTransportUserController::class, "index"]);
    Route::post("payment-transport-users", [PaymentTransportUserController::class, "create"]);
    Route::get("payment-transport-users/{payment_transport_user}", [PaymentTransportUserController::class, "show"]);
    Route::put("payment-transport-users/{payment_transport_user}", [PaymentTransportUserController::class, "update"]);
    Route::post("payment-transport-users/trash", [PaymentTransportUserController::class, "trash"]);
    Route::post("payment-transport-users/restore", [PaymentTransportUserController::class, "restore"]);
    Route::post("payment-transport-users/delete", [PaymentTransportUserController::class, "destroy"]);
    Route::post("payment-transport-users/balance", [PaymentTransportUserController::class, "calculateBalanceTranmobsportUser"]);


    // Route::post("modify-annual-decision", [UserController::class, "modifyAnnualDecision"]);
    Route::post("modify-annual-decision", [UserController::class, "modifyAnnualDecisionSmart"]);

    // Routes pour SchoolDelay (structure identique à TransportUser)
    Route::post("school-delaysall", [SchoolDelayController::class, "index"]);
    Route::post("school-delays", [SchoolDelayController::class, "create"]);
    Route::get("school-delays/{school_delay}", [SchoolDelayController::class, "show"]);
    Route::put("school-delays/{school_delay}", [SchoolDelayController::class, "update"]);
    Route::post("school-delays/trash", [SchoolDelayController::class, "trash"]);
    Route::post("school-delays/restore", [SchoolDelayController::class, "restore"]);
    Route::post("school-delays/delete", [SchoolDelayController::class, "destroy"]);

    // Routes pour Piece
    Route::post("piecesall", [PieceController::class, "index"]);
    Route::post("pieces", [PieceController::class, "create"]);
    Route::get("pieces/{piece}", [PieceController::class, "show"]);
    Route::put("pieces/{piece}", [PieceController::class, "update"]);
    Route::post("pieces/trash", [PieceController::class, "trash"]);
    Route::post("pieces/restore", [PieceController::class, "restore"]);
    Route::post("pieces/delete", [PieceController::class, "destroy"]);

    Route::post("meeting-reportsall", [MeetingReportController::class, "index"]);
    Route::post("meeting-reports", [MeetingReportController::class, "create"]);
    Route::get("meeting-reports/{meeting_report}", [MeetingReportController::class, "show"]);
    Route::put("meeting-reports/{meeting_report}", [MeetingReportController::class, "update"]);
    Route::post("meeting-reports/trash", [MeetingReportController::class, "trash"]);
    Route::post("meeting-reports/restore", [MeetingReportController::class, "restore"]);
    Route::post("meeting-reports/delete", [MeetingReportController::class, "destroy"]);

    Route::post("explanation-requestsall", [ExplanationRequestController::class, "index"]);
    Route::post("explanation-requests", [ExplanationRequestController::class, "create"]);
    Route::get("explanation-requests/{explanationRequest}", [ExplanationRequestController::class, "show"]);
    Route::put("explanation-requests/{explanationRequest}", [ExplanationRequestController::class, "update"]);
    Route::post("explanation-requests/trash", [ExplanationRequestController::class, "trash"]);
    Route::post("explanation-requests/restore", [ExplanationRequestController::class, "restore"]);
    Route::post("explanation-requests/delete", [ExplanationRequestController::class, "destroy"]);

    Route::post("memosall", [MemoController::class, "index"]);
    Route::post("memos", [MemoController::class, "create"]);
    Route::get("memos/{memo}", [MemoController::class, "show"]);
    Route::put("memos/{memo}", [MemoController::class, "update"]);
    Route::post("memos/trash", [MemoController::class, "trash"]);
    Route::post("memos/restore", [MemoController::class, "restore"]);
    Route::post("memos/delete", [MemoController::class, "destroy"]);

    Route::post("tutorialsall", [TutorialController::class, "index"]);
    Route::post("tutorials", [TutorialController::class, "create"]);
    Route::get("tutorials/{tutorial}", [TutorialController::class, "show"]);
    Route::put("tutorials/{tutorial}", [TutorialController::class, "update"]);
    Route::post("tutorials/trash", [TutorialController::class, "trash"]);
    Route::post("tutorials/restore", [TutorialController::class, "restore"]);
    Route::post("tutorials/delete", [TutorialController::class, "destroy"]);

    Route::post('semestres', [SemestreController::class, 'store']);
    Route::get('semestres/{id}', [SemestreController::class, 'show']);
    Route::post('semestresall', [SemestreController::class, 'index']);
    Route::put('semestres/{id}', [SemestreController::class, 'update']);
    Route::delete('semestres/{id}', [SemestreController::class, 'destroy']);
    Route::post('semestres/trash', [SemestreController::class, 'trashBulk']);
    Route::post('semestres/restore', [SemestreController::class, 'restoreBulk']);
    Route::post('semestres/delete', [SemestreController::class, 'destroyBulk']);

    Route::post("pensions-and-fees-list-period", [ListController::class, "getFinancialSummary"]);

});

Route::post('mobile-build-version', [MobileBuildVersionController::class, "store"]);
