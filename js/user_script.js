document.addEventListener('DOMContentLoaded', function () {
  let profile = document.querySelector('.header .flex .profile-detail'); 
  let searchForm = document.querySelector('.header .flex .search-form');
  let navbar = document.querySelector('.navbar');

  document.querySelector('#user-btn')?.addEventListener('click', function () {
      profile?.classList.toggle('active');
      searchForm?.classList.remove('active');
  });

  document.querySelector('#search-btn')?.addEventListener('click', function () {
      searchForm?.classList.toggle('active');
      profile?.classList.remove('active');
  });

  document.querySelector('#menu-btn')?.addEventListener('click', function () {
      navbar?.classList.toggle('active');
  });
});
