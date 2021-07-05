<div class="admin-form-div">
    <form action="./db/update-therapies.php" id="update-therapies" method="POST">
        <fieldset>
            <legend>קליניקה</legend>
            <p>פרישת הטיפולים כמו ואפשרות לסמן מאמר בבחירה מרובה לשם מחיקה ובנוסף מקום להוספת טיפולים</p>
            <input type="text" name="email" placeholder='שם משתמש'>
            <br>
            <input type="password" name="pass" id="regPass" placeholder="החלף סיסמא">
            <br>
            <input type="password" name="confirmPass" id="confirmPass" placeholder="אישור סיסמא">
            <br>
            <input type="password" name="oldPass" id="oldPass" placeholder="סיסמא קודמת">
            <br>
            <button name="update" value="UPDATE">עדכון</button>
            <br><br>
        </fieldset>
    </form>
</div>
