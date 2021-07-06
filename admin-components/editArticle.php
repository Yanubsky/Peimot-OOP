<div class="admin-form-div">
    <div id="edit-article-form-div">
        <form action="../req-handle.php?action=edit-article" id="edit-article" method="POST">
            <table dir="rtl">
                <caption>  רשימת המאמרים הקיימים במאגר הנתונים </caption>
                <tbody>
                <tr>
                    <th scope="col"> <input type="checkbox" name="mainCheckbox" id="mainCheckbox" class="articleTableCheckboxes" onclick="toggleCheckbox(this)"> </th>
                    <th scope="col"> עריכה </th>
                    <th scope="col"> מחיקה </th>
                    <th scope="col"> מאמר מספר </th>
                    <th scope="col"> נושא המאמר </th>
                    <th scope="col"> שם המאמר </th>
                    <th scope="col"> תאריך פרסום </th>
                    <th scope="col"> תמונה ראשית </th>
                </tr>
                <?php 
                    require_once SITE_ROOT.'/classes/Article.php';
                    Article::getList();
                ?> 
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php 
    include_once '../js-scripts.php';
?>

