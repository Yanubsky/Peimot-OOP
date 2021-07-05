<div class="admin-form-div">
    <form action="./db/about-handle.php" id="update-about" method="POST"></form>
        <fieldset>
            <legend>קצת עלי</legend>
            <div id="about-text">
            <input type="text" name="par" class="paragraph" placeholder='הכנס טקסט לעדכון'>
                <br>
                <label for="about-img">לצרף תמונה</label>
                <input type="file" name="about-img" class="about-img" accept="image/*">
                <button onclick="addAboutPrg()" id="tempBtn">הוסף פסקה</button> 
            </div>
            <br>
            <button type="submit" name="updateAbout" value="updateAbout">עדכן</button>
            <br><br>
        </fieldset>
    </form>
</div>

<?php 
    include '../js-scripts.php';
?>