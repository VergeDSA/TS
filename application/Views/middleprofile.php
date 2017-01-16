    <!-- Middle Column -->
    <div class="w3-col m7">

    <style>
        label {
            float: left;
            display: inline-block;
            width: 17em;
            text-align: right;
            margin-right: 1em;
        }
        input.submit {
            margin-left: 18em;
        }
        .input {
            visibility: hidden;
        }
    </style>
    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <form name="userprofile" action="/profile/<?=$submitAction?>/" method="post">
                        <h4 class="w3-center">My Profile</h4>
                        <p><label for="userEmail">e-mail</label><input type="email" name="email" id="userEmail" value="<?=$user->email?>" disabled></p>
                        <p><label for="userFirstName">Имя</label><input type="text" name="firstName" id="userFirstName" value="<?=$user->firstName?>" <?=$allowEdit?>></p>
                        <p><label for="userMiddleName">Отчество</label><input type="text" name="middleName" id="userMiddleName" value="<?=$user->middleName?>" <?=$allowEdit?>></p>
                        <p><label for="userLastName">Фамилия</label><input type="text" name="lastName" id="userLastName" value="<?=$user->lastName?>" <?=$allowEdit?>></p>
                        <p><label for="userBirthday">Дата рождения</label><input type="date" name="birthday" id="userBirthday" value="<?=$user->birthday?>" <?=$allowEdit?>></p>
                        <p><label for="userSex">Пол</label> <input type="radio" name="sex" id="userSex" value="female" <?=(($user->sex=='female')? "checked ":"")?><?=$allowEdit?>> Женский
                            <input type="radio" name="sex" id="userSex" value="male" <?=(($user->sex=='male')? "checked ":"")?><?=$allowEdit?>> Мужской</p>
                        </p>
                        <input type="submit" class="submit" value="<?=$submitValue?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <form name="userphones" action="/profile/<?=$submitPhoneAction?>/" method="post">
                        <h4 class="w3-center">My Phones</h4>
                        <?php foreach ($userPhones as $userPhone): ?>
                            <p><label for="userPhone">Телефон</label><input type="text" name="phone" id="userPhone" value="<?=$userPhone->phone?>" disabled>
                                <input type="hidden" name="phoneID" value="<?=$userPhone->id?>">
                                <button type="submit" formaction="/profile/delete/">Удалить</button>
                        <?php endforeach; ?>
                        <p><label for="userLastName" class="<?=$submitPhoneAction?>">Введите номер</label><input type="text" name="newPhone" class="<?=$submitPhoneAction?>"></p>
                        <input type="submit" class="submit submitPhone" value="<?=$submitPhoneValue?>">
                    </form>
                </div>
            </div>
        </div>
    </div>


        <!-- End Middle Column -->
    </div>

