const select = document.querySelector('select[name="size"]');
const searchForm = document.querySelector('form[id="searchForm"]');

select.addEventListener('change', function () {
    searchForm.submit();
});
