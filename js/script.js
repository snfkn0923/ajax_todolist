$(document).ready(function() {
    loadTodos();

    $('#registerTodo').on('click', function() {
        const title = $('#newTitle').val();
        const description = $('#newDescription').val();

        if (title.trim() === "") {
            alert("タイトルを入力してください。");
            return;
        }

        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'add', title: title, description: description },
            success: function(response) {
                const bool = JSON.parse(response);
                bool.status ? (
                    alert('登録しました'),
                    loadTodos(),
                    $('#editModal').removeClass('flex').addClass('hidden')
                ) : alert('失敗');
            },
            error: function(xhr, status, error) {
                alert('error');
                console.error('Error adding todo:', error);
            }
        });
    });
    // Load todos
    function loadTodos() {
        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'get'},
            success: function(response) {
                // console.log(response);
            const todos = JSON.parse(response);
            $('#newTitle').val('');
            $('#newDescription').val('');
            $('.parent-div').empty();
            let htmlContent = '';
            if(todos.isExist){
            

$.each(todos.contents, function(index, todo) {
    htmlContent += `
        <div class="todo-list flex items-center border-b border-gray-300 px-3 ${todo.isDone === 1 ? 'bg-blue-500' : ''}">
            <div class="flex-1 pr-8">
                <h3 class="text-lg font-semibold">${todo.title}</h3>
                <p class="text-gray-500">${todo.description}</p>
            </div>
            <div class="flex space-x-3">
                <div>
                    <button type="button" name="edit_todo" class="btn btn-blue py-2 px-2 bg-blue-500 text-white rounded-xl" data-id="${todo.id}">編集</button>
                </div>
                <div>
                    <button type="button" name="complete_todo" class="py-2 px-2 bg-green-500 text-white rounded-xl complete_todo" data-id="${todo.id}">完了</button>
                </div>
                <div>
                    <button type="button" name="delete_todo" class="py-2 px-2 bg-red-500 text-white rounded-xl delete_todo" data-id="${todo.id}">削除</button>
                </div>
            </div>
        </div>
    `;
});

$('.parent-div').append(htmlContent);
                } else {
                    htmlContent += `<div class="py-4 flex items-center border-b border-gray-300 px-3">
                        <h3 class="text-lg font-semibold">To Do リストはありません</h3>
                    </div>`;
                    $('.parent-div').append(htmlContent);
                    // $('#todo-list').append(`<div class="py-4 flex items-center border-b border-gray-300 px-3">
                    //     <h3 class="text-lg font-semibold">To Do リストはありません</h3>
                    // </div>`);

                }
            },
            error: function(xhr, status, error) {
                console.log(xhr,status,error);  
            }
        });
    }

    $('.parent-div').on('click', 'button[name="edit_todo"]', function() {
        let dataId = $(this).attr('data-id');
        loadModalData(dataId);
        
    });

    // モーダルを閉じるボタンのクリックイベント
    $('#closeModalBtn').click(function() {
        $('#editModal').removeClass('flex').addClass('hidden');
    });

    // モーダルの外側（背景）をクリックしたときにも閉じる
    $('#editModal').click(function(event) {
        if (event.target === this) {
            $(this).removeClass('flex').addClass('hidden');
        }
    });
    
      function loadModalData(dataId) {
        const id = dataId;
        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'getModal',id: id},
            success: function(response) {
            const todo = JSON.parse(response);
            console.log(response);
            $('#modalTitle').val(todo.title);
            $('#modalDescription').val(todo.description);
            $('#modalId').val(todo.id);
            $('#editModal').removeClass('hidden').addClass('flex');
            },
            error: function(xhr, status, error) {
                console.log(xhr,status,error);  
            }
        });
    }

    $('#updateTodo').on('click', function() {
        const title = $('#modalTitle').val();
        const description = $('#modalDescription'). val();
        const id = $('#modalId').val();
    
        if (title.trim() === "") {
            alert("タイトルを入力してください。");
            return;
        }
    
        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'update', title: title, description: description, id: id },
            success: function(response) {
                console.log(response);
                const bool = JSON.parse(response);
                bool.status ? (
                    alert('更新しました'),
                    loadTodos(),
                    $('#editModal').removeClass('flex').addClass('hidden')
                ) : alert('失敗');
                
            },
            error: function(xhr, status, error) {
                alert('error');
                console.error('Error adding todo:', error);
            }
        });
    });

    $('.parent-div').on('click', 'button[name="complete_todo"]', function() {
        let id = $(this).attr('data-id');
        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'complete', id: id },
            success: function(response) {
                const bool = JSON.parse(response);
                bool.status ? (
                    alert('更新しました'),
                    loadTodos(),
                    $('#editModal').removeClass('flex').addClass('hidden')
                ) : alert('失敗');
                
            },
            error: function(xhr, status, error) {
                alert('error');
                console.error('Error adding todo:', error);
            }
        });
        
        
    });

    $('.parent-div').on('click', 'button[name="delete_todo"]', function() {
        let id = $(this).attr('data-id');
        $.ajax({
            url: 'api/todo.php',
            type: 'POST',
            data: { action: 'delete', id: id },
            success: function(response) {
                const bool = JSON.parse(response);
                bool.status ? (
                    alert('削除しました'),
                    loadTodos(),
                    $('#editModal').removeClass('flex').addClass('hidden')
                ) : alert('失敗');
                
            },
            error: function(xhr, status, error) {
                alert('error');
                console.error('Error adding todo:', error);
            }
        });
        
        
    });


});



