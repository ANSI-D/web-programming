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

  // Handle Edit and Delete Actions for Users
  $('#users-table').on('click', '.edit-user', function () {
    const userId = $(this).data('id');
    console.log('Edit user:', userId);
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
    console.log('Edit post:', postId);
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
    console.log('Edit category:', categoryId);
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
});