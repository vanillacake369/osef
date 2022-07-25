<!-- Ref : https://www.bootdey.com/snippets/view/bs4-profile-about -->

<?php include_once "header.html"; ?>

<?php include_once "check-session.php"; ?>

<body>
    <!-- add default header -->
    <?php include_once "header.html"; ?>

    <!-- add default profile -->
    <?php include_once "member-profile.php"; ?>
    
    <!-- begin member info modify section -->
    <section>
        <div class="profile-content">
            <div class="tab-content p-0">
                <!-- begin member info input -->
                <div class="tab-pane fade in active show" id="profile-about">
                <form action="member-modify.php" method="post">
                        <!-- #2 PASSWORD VERIFICATION -->
                        <script>
                            var check = function () {
                                if (document.getElementById('pw').value ==
                                    document.getElementById('cpassword').value) {
                                    document.getElementById('message').style.color = 'green';
                                    document.getElementById('message').innerHTML = 'matching';
                                } else {
                                    document.getElementById('message').style.color = 'red';
                                    document.getElementById('message').innerHTML = 'not matching';
                                }
                            }
                        </script>
                        <label>비밀번호<span class="red_dot">*</span></label>
                        <div class="input_row">
                            <input type="password" name="pw" id="pw" class="input_text" value="" minlength="8"
                                maxlength="30" required="" onkeyup='check();'>
                        </div>
                        <label>비밀번호 재확인<span class="red_dot">*</span></label>
                        <div class="input_row">
                            <input type="password" name="cpassword" id="cpassword" class="input_text" value="" minlength="8"
                                maxlength="30" required="" onkeyup='check();'>
                        </div>
                        <span id='message'></span>
                        <span class="text-danger"></span>
                        <label>이름<span class="red_dot">*</span></label>
                        <div class="input_row">
                            <input type="text" name="name" class="input_text" value="" maxlength="50" required="">
                        </div>
                        <label>이메일</label>
                        <div class="input_row">
                            <input type="email" name="email" class="input_text" value="" maxlength="30">
                        </div>
                        <label>휴대전화<span class="red_dot">*</span></label>
                        <div class="input_row">
                            <input type="tel" name="phone" class="input_text" value="" maxlength="16"
                                pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required placeholder="010-xxxx-xxxx">
                        </div>
                        <label>주소<span class="red_dot">*</span></label>
                        <div class="input_row">
                            <input type="text" name="address" class="input_text" value="" maxlength="128" required=""
                                placeholder="~시 ~읍/면/동/리">
                        </div>
                        <div class="modify_submit">
                            <button type="modify" class="btn_modify" name="modify">
                                <span class="btn_text">회원정보 수정</span>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- end member info input -->
        </section>
        <!-- end member info modify section -->

    <!-- add footer -->
    <?php include_once "footer.html"; ?>
</body>
</html>