<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Product Management System</h1>

        <!-- Alert Message -->
        <div id="alert-container" class="mb-4"></div>

        <!-- Add Product Button -->
        <div class="flex justify-end mb-4">
            <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </button>
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                        <th class="w-2/6 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                        <th class="w-2/6 text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
                        <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Stock</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="products-table-body">
                    <!-- Product rows will be inserted here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="product-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="product-form" onsubmit="handleFormSubmit(event)">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Product</h3>
                        <input type="hidden" id="product-id">
                        <div class="mt-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p id="name-error" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <div class="mt-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                             <p id="price-error" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div class="mt-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" name="stock" id="stock" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p id="stock-error" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" id="form-submit-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    const modal = document.getElementById('product-modal');
    const form = document.getElementById('product-form');
    const modalTitle = document.getElementById('modal-title');
    const productIdInput = document.getElementById('product-id');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const stockInput = document.getElementById('stock');
    const tableBody = document.getElementById('products-table-body');
    const alertContainer = document.getElementById('alert-container');

    const api = axios.create({
        baseURL: '/api'
    });

    function showAlert(message, type = 'success') {
        const alertType = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        const alert = `
            <div class="${alertType} text-white font-bold rounded-t px-4 py-2">
                ${type === 'success' ? 'Success' : 'Error'}
            </div>
            <div class="border border-t-0 ${type === 'success' ? 'border-green-400 bg-green-100 text-green-700' : 'border-red-400 bg-red-100 text-red-700'} rounded-b px-4 py-3">
                <p>${message}</p>
            </div>
        `;
        alertContainer.innerHTML = alert;
        setTimeout(() => {
            alertContainer.innerHTML = '';
        }, 3000);
    }

    function clearErrors() {
        document.getElementById('name-error').classList.add('hidden');
        document.getElementById('price-error').classList.add('hidden');
        document.getElementById('stock-error').classList.add('hidden');
    }

    function validateForm() {
        clearErrors();
        let isValid = true;
        
        if (!nameInput.value.trim()) {
            document.getElementById('name-error').textContent = 'Name is required.';
            document.getElementById('name-error').classList.remove('hidden');
            isValid = false;
        }

        const price = parseFloat(priceInput.value);
        if (isNaN(price) || price <= 0) {
             document.getElementById('price-error').textContent = 'Price must be a number greater than 0.';
             document.getElementById('price-error').classList.remove('hidden');
             isValid = false;
        }

        const stock = parseInt(stockInput.value);
        if (isNaN(stock) || stock < 0) {
            document.getElementById('stock-error').textContent = 'Stock must be an integer of 0 or more.';
            document.getElementById('stock-error').classList.remove('hidden');
            isValid = false;
        }

        return isValid;
    }

    async function fetchProducts() {
        try {
            const response = await api.get('/products');
            const products = response.data.data;
            tableBody.innerHTML = '';
            products.forEach(product => {
                const row = `
                    <tr class="border-b">
                        <td class="py-3 px-4">${product.id}</td>
                        <td class="py-3 px-4">${product.name}</td>
                        <td class="py-3 px-4">${product.price}</td>
                        <td class="py-3 px-4">${product.stock}</td>
                        <td class="py-3 px-4">
                            <button onclick="editProduct(${product.id})" class="text-blue-500 hover:text-blue-800">Edit</button>
                            <button onclick="deleteProduct(${product.id})" class="text-red-500 hover:text-red-800 ml-2">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        } catch (error) {
            showAlert('Failed to fetch products.', 'error');
            console.error(error);
        }
    }

    function openModal(product = null) {
        form.reset();
        clearErrors();
        if (product) {
            modalTitle.textContent = 'Edit Product';
            productIdInput.value = product.id;
            nameInput.value = product.name;
            descriptionInput.value = product.description;
            priceInput.value = product.price;
            stockInput.value = product.stock;
        } else {
            modalTitle.textContent = 'Add Product';
            productIdInput.value = '';
        }
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        if (!validateForm()) {
            return;
        }

        const id = productIdInput.value;
        const data = {
            name: nameInput.value,
            description: descriptionInput.value,
            price: priceInput.value,
            stock: stockInput.value,
        };

        try {
            if (id) {
                // Update
                const response = await api.put(`/products/${id}`, data);
                showAlert('Product updated successfully!');
            } else {
                // Create
                const response = await api.post('/products', data);
                showAlert('Product created successfully!');
            }
            closeModal();
            fetchProducts();
        } catch (error) {
            const errorMessage = error.response?.data?.message || 'An error occurred.';
            showAlert(errorMessage, 'error');
            console.error(error);
        }
    }

    async function editProduct(id) {
        try {
            const response = await api.get(`/products/${id}`);
            openModal(response.data.data);
        } catch (error) {
            showAlert('Failed to fetch product data.', 'error');
            console.error(error);
        }
    }

    async function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            try {
                await api.delete(`/products/${id}`);
                showAlert('Product deleted successfully!');
                fetchProducts();
            } catch (error) {
                showAlert('Failed to delete product.', 'error');
                console.error(error);
            }
        }
    }

    // Initial fetch
    document.addEventListener('DOMContentLoaded', fetchProducts);
</script>

</body>
</html>
