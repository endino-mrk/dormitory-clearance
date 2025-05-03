<?php
// Include helper functions
include_once 'includes/functions.php';

// Set page title
$pageTitle = 'Manage Residents';

// Sample data for residents
$residents = [
    [
        'id' => 'R-0001',
        'name' => 'Jessica Davis',
        'email' => 'jessica.davis@example.com',
        'room' => 'Room 201',
        'building' => 'Building A',
        'phone' => '+1 (555) 123-4567',
        'move_in' => '2023-09-01',
        'status' => 'Active'
    ],
    [
        'id' => 'R-0002',
        'name' => 'Robert Harris',
        'email' => 'robert.harris@example.com',
        'room' => 'Room 315',
        'building' => 'Building B',
        'phone' => '+1 (555) 234-5678',
        'move_in' => '2023-08-15',
        'status' => 'Active'
    ],
    [
        'id' => 'R-0003',
        'name' => 'Amanda Miller',
        'email' => 'amanda.miller@example.com',
        'room' => 'Room 107',
        'building' => 'Building A',
        'phone' => '+1 (555) 345-6789',
        'move_in' => '2024-01-10',
        'status' => 'Active'
    ],
    [
        'id' => 'R-0004',
        'name' => 'Kevin Wilson',
        'email' => 'kevin.wilson@example.com',
        'room' => 'Room 422',
        'building' => 'Building C',
        'phone' => '+1 (555) 456-7890',
        'move_in' => '2023-11-05',
        'status' => 'Moving Out'
    ],
    [
        'id' => 'R-0005',
        'name' => 'Emma Thompson',
        'email' => 'emma.thompson@example.com',
        'room' => 'Room 304',
        'building' => 'Building A',
        'phone' => '+1 (555) 567-8901',
        'move_in' => '2024-04-01',
        'status' => 'Active'
    ],
    [
        'id' => 'R-0006',
        'name' => 'Michael Johnson',
        'email' => 'michael.johnson@example.com',
        'room' => 'Room 210',
        'building' => 'Building A',
        'phone' => '+1 (555) 678-9012',
        'move_in' => '2023-08-20',
        'status' => 'Inactive'
    ]
];

// Include header
include 'includes/header.php';
?>

<!-- Page Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manage Residents</h1>
        <p class="mt-1 text-sm text-gray-500">Add, edit, or remove dormitory residents</p>
    </div>
    <button class="bg-primary text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-indigo-700 transition-colors transform hover:scale-105 duration-200">
        <i class="ri-user-add-line"></i>
        <span>Add New Resident</span>
    </button>
</div>

<!-- Search and Filters -->
<div class="mb-6 bg-white p-4 rounded-md shadow hover:shadow-md transition-all">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="ri-search-line text-gray-400"></i>
                </div>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Search residents...">
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 hover:bg-gray-100 transition-colors">
                <option selected>All Buildings</option>
                <option>Building A</option>
                <option>Building B</option>
                <option>Building C</option>
            </select>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 hover:bg-gray-100 transition-colors">
                <option selected>All Floors</option>
                <option>1st Floor</option>
                <option>2nd Floor</option>
                <option>3rd Floor</option>
                <option>4th Floor</option>
            </select>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 hover:bg-gray-100 transition-colors">
                <option selected>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
                <option>Moving Out</option>
            </select>
            <button class="p-2.5 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all">
                <i class="ri-filter-3-line"></i>
            </button>
        </div>
    </div>
</div>

<!-- Residents Table -->
<div class="bg-white shadow rounded-md overflow-hidden mb-6 hover:shadow-md transition-all">
    <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Resident List</h2>
        <div class="flex space-x-2">
            <button class="p-1 text-gray-500 rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all">
                <i class="ri-download-line"></i>
            </button>
            <button class="p-1 text-gray-500 rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all">
                <i class="ri-printer-line"></i>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Resident
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Room
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Move-in Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($residents as $resident): ?>
                    <?php 
                    $statusClass = '';
                    $statusBg = '';
                    
                    switch ($resident['status']) {
                        case 'Active':
                            $statusClass = 'text-green-800';
                            $statusBg = 'bg-green-100';
                            break;
                        case 'Inactive':
                            $statusClass = 'text-red-800';
                            $statusBg = 'bg-red-100';
                            break;
                        case 'Moving Out':
                            $statusClass = 'text-yellow-800';
                            $statusBg = 'bg-yellow-100';
                            break;
                    }
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $resident['id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary bg-opacity-10 flex items-center justify-center text-primary">
                                    <span class="font-medium"><?php echo getInitials($resident['name']); ?></span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo $resident['name']; ?></div>
                                    <div class="text-sm text-gray-500"><?php echo $resident['email']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo $resident['room']; ?></div>
                            <div class="text-sm text-gray-500"><?php echo $resident['building']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $resident['phone']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo formatDate($resident['move_in']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusBg; ?> <?php echo $statusClass; ?>">
                                <?php echo $resident['status']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-2 justify-end">
                                <button class="text-indigo-600 hover:text-indigo-900 transform hover:scale-110 transition-transform">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900 transform hover:scale-110 transition-transform">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 transform hover:scale-110 transition-transform">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 bg-gray-50 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transform hover:scale-105 transition-transform">
                Previous
            </button>
            <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transform hover:scale-105 transition-transform">
                Next
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">50</span> results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transform hover:scale-105 transition-transform">
                        <span class="sr-only">Previous</span>
                        <i class="ri-arrow-left-s-line"></i>
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white hover:bg-primary-dark transform hover:scale-105 transition-transform">
                        1
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transform hover:scale-105 transition-transform">
                        2
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transform hover:scale-105 transition-transform">
                        3
                    </button>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                        ...
                    </span>
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transform hover:scale-105 transition-transform">
                        8
                    </button>
                    <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transform hover:scale-105 transition-transform">
                        <span class="sr-only">Next</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include 'includes/footer.php';
?>