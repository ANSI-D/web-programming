$.fn.dataTable.ext.errMode = 'none';

$(document).ready(function () {
  // Initialize Users Table
  const usersTable = $('#users-table').DataTable({
    ajax: function (data, callback, settings) {
      RestClient.get('users', function (response) {
        callback({ data: response.data });
      }, function (error) {
        alert('Failed to fetch users.');
      });
    },
    columns: [
      { data: 'id' },          // Maps to 'id' in the API response
      { data: 'username' },    // Maps to 'username' in the API response
      { data: 'email' },       // Maps to 'email' in the API response
      { data: 'role' },        // Maps to 'role' in the API response
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-primary edit-user" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-danger delete-user" data-id="${row.id}">Delete</button>
          `;
        }
      }
    ]
  });

  // Initialize Posts Table
  const postsTable = $('#posts-table').DataTable({
    ajax: function (data, callback, settings) {
      RestClient.get('posts', function (response) {
        callback({ data: response.data });
      }, function (error) {
        alert('Failed to fetch posts.');
      });
    },
    columns: [
      { data: 'id' },
      { data: 'title' },
      { data: 'author' },
      { data: 'category' },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-primary edit-post" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-danger delete-post" data-id="${row.id}">Delete</button>
          `;
        }
      }
    ]
  });

  // Initialize Categories Table
  const categoriesTable = $('#categories-table').DataTable({
    ajax: function (data, callback, settings) {
      RestClient.get('categories', function (response) {
        callback({ data: response.data });
      }, function (error) {
        alert('Failed to fetch categories.');
      });
    },
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'description' },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-primary edit-category" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-danger delete-category" data-id="${row.id}">Delete</button>
          `;
        }
      }
    ]
  });

  // Initialize Comments Table
  const commentsTable = $('#comments-table').DataTable({
    ajax: function (data, callback, settings) {
      RestClient.get('comments', function (response) {
        callback({ data: response.data });
      }, function (error) {
        alert('Failed to fetch comments.');
      });
    },
    columns: [
      { data: 'id' },
      { data: 'content' },
      { data: 'author' },
      { data: 'post' },
      {
        data: null,
        render: function (data, type, row) {
          return `
            <button class="btn btn-sm btn-primary edit-comment" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-danger delete-comment" data-id="${row.id}">Delete</button>
          `;
        }
      }
    ]
  });
  // Handle Edit and Delete Actions for Users
  $('#users-table').on('click', '.edit-user', function () {
    const userId = $(this).data('id');
    // Fetch user data and populate modal
    RestClient.get(`users/${userId}`, function (response) {
      $('#editUserId').val(response.id);
      $('#editUsername').val(response.username);
      $('#editUserEmail').val(response.email);
      $('#editUserRole').val(response.role);
      $('#editUserModal').modal('show');
    }, function (error) {
      alert('Failed to fetch user data.');
    });
  });

  $('#users-table').on('click', '.delete-user', function () {
    const userId = $(this).data('id');
    if (confirm('Are you sure you want to delete this user?')) {
      RestClient.delete(`users/delete/${userId}`, {}, function () {
        usersTable.ajax.reload();
      }, function () {
        alert('Failed to delete user.');
      });
    }
  });
  // Handle Edit and Delete Actions for Posts
  $('#posts-table').on('click', '.edit-post', function () {
    const postId = $(this).data('id');
    // Fetch post data and populate modal
    RestClient.get(`posts/${postId}`, function (response) {
      $('#editPostId').val(response.id);
      $('#editPostTitle').val(response.title);
      $('#editPostAuthor').val(response.author);
      $('#editPostCategory').val(response.category);
      $('#editPostContent').val(response.content || '');
      $('#editPostModal').modal('show');
    }, function (error) {
      alert('Failed to fetch post data.');
    });
  });

  $('#posts-table').on('click', '.delete-post', function () {
    const postId = $(this).data('id');
    if (confirm('Are you sure you want to delete this post?')) {
      RestClient.delete(`posts/delete/${postId}`, {}, function () {
        postsTable.ajax.reload();
      }, function () {
        alert('Failed to delete post.');
      });
    }
  });
  // Handle Edit and Delete Actions for Categories
  $('#categories-table').on('click', '.edit-category', function () {
    const categoryId = $(this).data('id');
    // Fetch category data and populate modal
    RestClient.get(`categories/${categoryId}`, function (response) {
      $('#editCategoryId').val(response.id);
      $('#editCategoryName').val(response.name);
      $('#editCategoryDescription').val(response.description || '');
      $('#editCategoryModal').modal('show');
    }, function (error) {
      alert('Failed to fetch category data.');
    });
  });

  $('#categories-table').on('click', '.delete-category', function () {
    const categoryId = $(this).data('id');
    if (confirm('Are you sure you want to delete this category?')) {
      RestClient.delete(`categories/delete/${categoryId}`, {}, function () {
        categoriesTable.ajax.reload();
      }, function () {
        alert('Failed to delete category.');
      });
    }
  });
  // Handle Edit and Delete Actions for Comments
  $('#comments-table').on('click', '.edit-comment', function () {
    const commentId = $(this).data('id');
    // Fetch comment data and populate modal
    RestClient.get(`comments/${commentId}`, function (response) {
      $('#editCommentId').val(response.id);
      $('#editCommentContent').val(response.content);
      $('#editCommentAuthor').val(response.author);
      $('#editCommentPost').val(response.post);
      $('#editCommentModal').modal('show');
    }, function (error) {
      alert('Failed to fetch comment data.');
    });
  });

  $('#comments-table').on('click', '.delete-comment', function () {
    const commentId = $(this).data('id');
    if (confirm('Are you sure you want to delete this comment?')) {
      RestClient.delete(`comments/delete/${commentId}`, {}, function () {
        commentsTable.ajax.reload();
      }, function () {
        alert('Failed to delete comment.');
      });
    }
  });
});

// Save User Changes
$('#saveUserChanges').on('click', function () {
  const userData = {
    id: $('#editUserId').val(),
    username: $('#editUsername').val(),
    email: $('#editUserEmail').val(),
    role: $('#editUserRole').val()
  };

  RestClient.post(`users/add`, userData, function (response) {
    $('#editUserModal').modal('hide');
    $('#users-table').DataTable().ajax.reload();
    alert('User updated successfully!');
  }, function (error) {
    alert('Failed to update user.');
  });
});

// Save Post Changes
$('#savePostChanges').on('click', function () {
  const postData = {
    id: $('#editPostId').val(),
    title: $('#editPostTitle').val(),
    author: $('#editPostAuthor').val(),
    category: $('#editPostCategory').val(),
    content: $('#editPostContent').val()
  };

  RestClient.post(`posts/add`, postData, function (response) {
    $('#editPostModal').modal('hide');
    $('#posts-table').DataTable().ajax.reload();
    alert('Post updated successfully!');
  }, function (error) {
    alert('Failed to update post.');
  });
});

// Save Category Changes
$('#saveCategoryChanges').on('click', function () {
  const categoryData = {
    id: $('#editCategoryId').val(),
    name: $('#editCategoryName').val(),
    description: $('#editCategoryDescription').val()
  };

  RestClient.put(`categories/update/${categoryData.id}`, categoryData, function (response) {
    $('#editCategoryModal').modal('hide');
    $('#categories-table').DataTable().ajax.reload();
    alert('Category updated successfully!');
  }, function (error) {
    alert('Failed to update category.');
  });
});

// Save Comment Changes
$('#saveCommentChanges').on('click', function () {
  const commentData = {
    id: $('#editCommentId').val(),
    content: $('#editCommentContent').val(),
    author: $('#editCommentAuthor').val(),
    post: $('#editCommentPost').val()
  };

  RestClient.put(`comments/update/${commentData.id}`, commentData, function (response) {
    $('#editCommentModal').modal('hide');
    $('#comments-table').DataTable().ajax.reload();
    alert('Comment updated successfully!');
  }, function (error) {
    alert('Failed to update comment.');
  });
});