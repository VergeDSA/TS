<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <!-- The Grid -->
    <div class="w3-row">
        <!-- Left Column -->
        <div class="w3-col m3">
            <!-- Profile -->
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container">
                    <h4 class="w3-center">My Profile</h4>
                    <p class="w3-center"><img src="/../avatars/<?=$userAvatar->fileName?>" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
                    <hr>
                    <!--         <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p> -->
                    <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> г.<?=$userCities[0]->city->name?>, <?=$userCities[0]->city->country->name?></p>
                    <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> <?=$user->birthday?></p>
                </div>
            </div>
            <br>

            <!-- Accordion -->
            <div class="w3-card-2 w3-round">
                <div class="w3-accordion w3-white">
                    <button onclick="myFunction('Demo1')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Groups</button>
                    <div id="Demo1" class="w3-accordion-content w3-container">
                        <?php foreach ($userGroups as $userGroup): ?>
                            <p><?=$userGroup->group->name?></p>
                        <?php endforeach; ?>
                    </div>
                    <button onclick="myFunction('Demo2')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
                    <div id="Demo2" class="w3-accordion-content w3-container">
                        <p>Coming soon...</p>
                    </div>
                    <button onclick="myFunction('Demo3')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Albums</button>
                    <div id="Demo3" class="w3-accordion-content w3-container">
                        <div class="w3-row-padding">
                            <br>
                            <?php foreach ($userAlbums as $userAlbum): ?>
                                <div class="w3-half">
                                    <img src="/../photos/<?=$userAlbum->album->albumPhoto[0]->fileName?>" style="width:100%" class="w3-margin-bottom" alt="<?=$userAlbum->album->name?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Interests -->
            <div class="w3-card-2 w3-round w3-white w3-hide-small">
                <div class="w3-container">
                    <p>Interests</p>
                    <p>
                        <!--            <span class="w3-tag w3-small w3-theme-d5">News</span>
                                    <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                                    <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                                    <span class="w3-tag w3-small w3-theme-d2">Games</span>
                                    <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                                    <span class="w3-tag w3-small w3-theme">Games</span>
                                    <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                                    <span class="w3-tag w3-small w3-theme-l2">Food</span>
                                    <span class="w3-tag w3-small w3-theme-l3">Design</span>
                                    <span class="w3-tag w3-small w3-theme-l4">Art</span>
                                    <span class="w3-tag w3-small w3-theme-l5">Photos</span> -->
                        Coming soon...
                    </p>
                </div>
            </div>
            <br>

            <!-- Alert Box -->
            <div class="w3-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
                <!--        <span onclick="this.parentElement.style.display='none'" class="w3-hover-text-grey w3-closebtn">
                          <i class="fa fa-remove"></i>
                        </span> -->
                <p><strong>Hey!</strong></p>
                <p>People are looking at your profile. Find out who.</p>
                <p></p>
                <p>Coming soon...</p>
            </div>

            <!-- End Left Column -->
        </div>

        <script>
            // Accordion
            function myFunction(id) {
                var x = document.getElementById(id);
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                    x.previousElementSibling.className += " w3-theme-d1";
                } else {
                    x.className = x.className.replace("w3-show", "");
                    x.previousElementSibling.className =
                        x.previousElementSibling.className.replace(" w3-theme-d1", "");
                }
            }
        </script>