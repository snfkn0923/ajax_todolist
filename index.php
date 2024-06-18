<!DOCTYPE html>
<html>

<head>
    <title>Ajax ToDo List</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js/script.js"></script>
</head>

<body>
    <div class="bg-gray p-4">
        <div class="lg:w-2/4 mx-auto py-8 px-6 bg-white rounded-xl">
            <h1 class="font-bold text-2xl mb-8">新規作成</h1>
            <div class="block mb-6">
                <div class="flex flex-col space-y-4" action="">
                    <input type="text" name="title" id="newTitle" placeholder="タイトル"
                        class="py-3 px-4 bg-gray-100 rounded-xl">
                    <textarea name="description" id="newDescription" cols="30" rows="3" placeholder="概要"
                        class="py-3 px-4 bh-gray-100 rounded-xl"></textarea>
                    <button type="button" id="registerTodo"
                        class="w-28 py-4 px-5 bg-green-500 text-white rounded-xl">登録</button>
                </div>
                <h1 class="font-bold text-2xl mb-2 mt-2">To Do リスト</h1>
                <hr>
                <div class="mt-2 parent-div">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div id="editModal"
        class="fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <!-- モーダルのコンテンツ -->
        <div class="bg-white w-1/2 p-8 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">モーダル編集</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M14.707 5.293a1 1 0 0 1 0 1.414L11.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 1 1-1.414-1.414L8.586 10 5.293 6.707a1 1 0 0 1 1.414-1.414L10 8.586l3.293-3.293a1 1 0 0 1 1.414 0z" />
                    </svg>
                </button>
            </div>
            <div class="block mb-6">
                <div class="flex flex-col space-y-4" action="">
                    <input type="hidden" id="modalId">
                    <input type="text" name="title" id="modalTitle" placeholder="タイトル"
                        class="py-3 px-4 bg-gray-100 rounded-xl">
                    <textarea name="description" id="modalDescription" cols="30" rows="3" placeholder="概要"
                        class="py-3 px-4 bh-gray-100 rounded-xl"></textarea>
                    <button type="button" id="updateTodo"
                        class="w-28 py-4 px-5 bg-green-500 text-white rounded-xl">更新</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>