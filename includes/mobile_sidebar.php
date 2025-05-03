<?php
// Include helper functions if not already included
if (!function_exists('isPageActive')) {
    include_once 'functions.php';
}
?>
<!-- Mobile Sidebar -->
<div class="fixed inset-0 z-40 hidden" id="mobileSidebar">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="sidebarOverlay"></div>
    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
        <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" id="closeSidebar">
                <span class="sr-only">Close sidebar</span>
                <i class="ri-close-line text-white"></i>
            </button>
        </div>
        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 flex items-center px-4">
                <h1 class="text-xl font-['Pacifico'] text-primary">DormClear</h1>
            </div>
            <nav class="mt-5 px-2 space-y-1">
                <a href="index.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('index.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-dashboard-line"></i>
                    </div>
                    Overview
                </a>
                <a href="manage_residents.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('manage_residents.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-user-line"></i>
                    </div>
                    Manage Residents
                </a>
                <a href="clearance_status.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('clearance_status.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-check-double-line"></i>
                    </div>
                    Clearance Status
                </a>
                <a href="rental_fees.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('rental_fees.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    Rental Fees
                </a>
                <a href="fines.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('fines.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-bill-line"></i>
                    </div>
                    Fines
                </a>
                <a href="payment_history.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('payment_history.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-history-line"></i>
                    </div>
                    Payment History
                </a>
                <a href="room_status.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('room_status.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-home-line"></i>
                    </div>
                    Room Status
                </a>
                <a href="document_tracker.php" class="group flex items-center px-2 py-2 text-base font-medium rounded-md <?php echo isPageActive('document_tracker.php') ? 'bg-primary bg-opacity-10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                    <div class="w-6 h-6 mr-4 flex items-center justify-center">
                        <i class="ri-file-list-line"></i>
                    </div>
                    Document Tracker
                </a>
            </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
            <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-medium">
                        JD
                    </div>
                    <div class="ml-3">
                        <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">John Doe</p>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">Dormitory Manager</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="flex-shrink-0 w-14"></div>
</div>