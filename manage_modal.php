<div class="modal fade manage_modal" id="SignUp" tabindex="-1" aria-labelledby="signUpModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">THÊM TÀI KHOẢN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-insert">




                <!-- start here -->
                <div class="form">
                    <div class="label-insert-modal">
                        <label for="new_users_id">Nhập thông tin cá nhân</label>
                    </div>
                    <input type="text" id="new_users_id" placeholder="Nhập mã sinh viên">
                    <input type="text" id="new_users_name" placeholder="Nhập tên đoàn viên">
                    <div class="label-insert-modal">
                        <label for="get-birthdate" id="get-birthdate-label" style="margin: 0;">Nhập ngày sinh</label>
                    </div>
                    <input type="date" name="get-birthdate" id="get-birthdate">
                    <select name="gender" id="gender">
                        <option value="none" class="gender-selection">Giới tính</option>
                        <option value="nam" class="gender-selection">Nam</option>
                        <option value="nu" class="gender-selection">Nữ</option>
                    </select>
                </div>
                <!--  end -->




                <!-- start here -->
                <div class="form">
                    <div class="label-insert-modal">
                        <label for="new_users_id">Nhập thông tin Đoàn viên</label>
                    </div>
                    <select name="get-depart" id="get-depart">
                        <option value="none">Khoa</option>
                        <option value="1">Khoa Công nghệ thông tin</option>
                        <option value="2">Khoa Hàng hải</option>
                        <option value="3">Khoa Kinh tế</option>
                        <option value="4">Khoa Quản trị - Tài chính</option>
                    </select>

                    <select name="get-class-list" id="get-class-list">
                        <option value="0">Chọn lớp</option>

                        <optgroup label="Khoa Công nghệ thông tin">
                            <option value="101">CNT</option>
                            <option value="102">KPM</option>
                            <option value="103">TTM</option>
                        </optgroup>

                        <optgroup label="Khoa Hàng hải">
                            <option value="201">HH</option>
                        </optgroup>

                        <optgroup label="Khoa Kinh tế">
                            <option value="301">KTB</option>
                            <option value="302">KTN</option>
                            <option value="303">KTL</option>
                            <option value="304">KTC</option>
                            <option value="305">KTH</option>
                        </optgroup>

                        <optgroup label="Khoa Quản trị - Tài chính">
                            <option value="401">QKT</option>
                            <option value="402">QKD</option>
                            <option value="403">QTC</option>
                        </optgroup>
                    </select>

                    <select name="get-year-in" id="get-year-in">
                        <option value="none">Niên khóa</option>
                        <option value="61">61</option>
                        <option value="62">62</option>
                        <option value="63">63</option>
                        <option value="64">64</option>
                        <option value="65">65</option>
                    </select>
                    <select class="selectpicker" data-live-search="true" name="get-role" id="get-role">
                        <option value="none">Chức vụ</option>
                        <option value="admin">Admin</option>
                        <option value="doanvien">Đoàn viên</option>
                        <option value="canbodoan">Cán bộ Đoàn</option>
                    </select>
                </div>
                <!-- end -->



                <!-- start here -->
                <div class="form">
                    <div class="label-insert-modal">
                        <label for="new_users_id">Nhập thông tin tài khoản</label>
                    </div>
                    <input type="email" name="get-user-email" id="get-user-email" placeholder="Email: ">
                    <input type="tel" name="get-user-tel" id="get-user-tel" placeholder="Nhập số điện thoại">
                    <hr style="width:80%">
                    <div class="label-insert-modal">
                        <label for="new_users_password">Tạo mật khẩu</label>
                    </div>
                    <input type="password" name="new_users_password" id="new_users_password" placeholder="Nhập mật khẩu">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Xác nhận mật khẩu">
                    <button type="button" class="btn btn-primary" id="insert-user-btn" style="width:80%;margin-top:30px; height: 45px">Thêm</button>
                </div>
                <!-- end here -->

            </div>
        </div>
    </div>
</div>
</div>









<div class="modal fade manage_modal modal-lg" id="filter" tabindex="-1" aria-labelledby="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">BỘ LỌC TÌM KIẾM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-filter ">
                <div class="search-container" style="display: flex; flex-direction:column;" id="input-filter">
                    <input type="text" name="search" id="search-user" placeholder="Nhập thông tin" style="background-color: white;">

                    <div id="content-modal-wrapper">
                        <div class="div-filter-container">
                            <select name="class-list" id="class-list">
                                <option value="none">Chọn lớp</option>
                                <optgroup label="Khoa Công nghệ thông tin">
                                    <option value="cnt">CNT</option>
                                    <option value="kpm">KPM</option>
                                    <option value="ttm">TTM</option>
                                </optgroup>

                                <optgroup label="Khoa Hàng hải">
                                    <option value="hh">HH</option>
                                </optgroup>

                                <optgroup label="Khoa Kinh tế">
                                    <option value="ktb">KTB</option>
                                    <option value="ktn">KTN</option>
                                    <option value="ktl">KTL</option>
                                    <option value="ktc">KTC</option>
                                    <option value="kth">KTH</option>
                                </optgroup>

                                <optgroup label="Khoa Quản trị - Tài chính">
                                    <option value="qkt">QKT</option>
                                    <option value="qkd">QKD</option>
                                    <option value="qtc">QTC</option>
                                </optgroup>

                            </select>


                            <select name="aca-year" id="aca-year">
                                <option value="none">Chọn khóa</option>
                                <option value="63">63</option>
                                <option value="64">64</option>
                                <option value="65">65</option>
                            </select>
                            <select name="uni-branch" id="uni-branch">
                                <option value="none">Chi đoàn</option>
                                <option value="2">Khoa Hàng hải</option>
                                <option value="3">Khoa Kinh tế</option>
                                <option value="1">Khoa Công nghệ thông tin</option>
                                <option value="4">Khoa Quản trị - Tài chính</option>
                            </select>
                        </div>



                        <div class="div-filter-container">
                            <select name="get-search-on" id="get-search-on">
                                <option value="none">Sắp xếp theo</option>
                                <option value="id">Mã sinh viên</option>
                                <option value="ho_ten">Họ tên</option>
                                <option value="lop_id">Lớp</option>
                                <option value="chidoan_id">Liên chi doàn</option>
                            </select>
                            <select name="get-sort-side" id="get-sort-side">
                                <option value="none">Sắp xếp chiều</option>
                                <option value="ASC">Tăng</option>
                                <option value="DESC">Giảm</option>
                            </select>
                            <button type="button" class="btn btn-primary" id="filter-btn">Tìm kiếm</button>

                        </div>

                    </div>


                    <hr style="width: 96%; margin: 10px auto; margin-top:20px">
                </div>
            </div>
        </div>
    </div>
</div>
</div>









<div class="modal fade manage_modal modal-xl" id="detail-data" tabindex="-1" aria-labelledby="detailDataModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail-data-label">Thông tin Đoàn viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-detail-data">


                <!-- start here -->
                <div class="form">
                    <div class="label-detail-modal">
                        <label for="show-user-id">Mã sinh viên</label>
                    </div>
                    <input type="text" id="show-user-id" placeholder="Nhập mã sinh viên">
                    <div class="label-detail-modal">
                        <label for="show-user-name">Họ và tên: </label>
                    </div>
                    <input type="text" id="show-user-name" placeholder="Nhập tên đoàn viên">
                    <div class="label-insert-modal">
                        <label for="show-user-birthdate" id="get-birthdate-label" style="margin: 0;">Ngày sinh</label>
                    </div>
                    <input type="date" name="show-user-birthdate" id="show-user-birthdate">
                    <div class="label-detail-modal">
                        <label for="show-user-gender">Giới tính: </label>
                    </div>
                    <select name="show-user-gender" id="show-user-gender">
                        <option value="none" class="gender-selection">Giới tính</option>
                        <option value="nam" class="gender-selection">Nam</option>
                        <option value="nu" class="gender-selection">Nữ</option>
                    </select>
                </div>
                <!--  end -->




                <!-- start here -->
                <div class="form">
                    <div class="label-detail-modal">
                        <label for="show-user-depart">Khoa:</label>
                    </div>
                    <select name="show-user-depart" id="show-user-depart">
                        <option value="none">Khoa</option>
                        <option value="1">Khoa Công nghệ thông tin</option>
                        <option value="2">Khoa Hàng hải</option>
                        <option value="3">Khoa Kinh tế</option>
                        <option value="4">Khoa Quản trị - Tài chính</option>
                    </select>
                    <div class="label-detail-modal">
                        <label for="get-user-class-list">Lớp:</label>
                    </div>
                    <select name="get-user-class-list" id="get-user-class-list">
                        <option value="0">Chọn lớp</option>

                        <optgroup label="Khoa Công nghệ thông tin">
                            <option value="101">CNT</option>
                            <option value="102">KPM</option>
                            <option value="103">TTM</option>
                        </optgroup>

                        <optgroup label="Khoa Hàng hải">
                            <option value="201">HH</option>
                        </optgroup>

                        <optgroup label="Khoa Kinh tế">
                            <option value="301">KTB</option>
                            <option value="302">KTN</option>
                            <option value="303">KTL</option>
                            <option value="304">KTC</option>
                            <option value="305">KTH</option>
                        </optgroup>

                        <optgroup label="Khoa Quản trị - Tài chính">
                            <option value="401">QKT</option>
                            <option value="402">QKD</option>
                            <option value="403">QTC</option>
                        </optgroup>
                    </select>
                    <div class="label-detail-modal">
                        <label for="show-user-year-in">Niên khóa:</label>
                    </div>
                    <select name="show-user-year-in" id="show-user-year-in">
                        <option value="none">Niên khóa</option>
                        <option value="61">61</option>
                        <option value="62">62</option>
                        <option value="63">63</option>
                        <option value="64">64</option>
                        <option value="65">65</option>
                    </select>
                    <div class="label-detail-modal">
                        <label for="show-user-role">Vai trò:</label>
                    </div>
                    <select class="selectpicker" data-live-search="true" name="show-user-role" id="show-user-role">
                        <option value="none">Chức vụ</option>
                        <option value="admin">Admin</option>
                        <option value="doanvien">Đoàn viên</option>
                        <option value="canbodoan">Cán bộ Đoàn</option>
                    </select>
                </div>
                <!-- end -->



                <!-- start here -->
                <div class="form">
                    <div class="label-detail-modal">
                        <label for="show-user-email">Email tài khoản:</label>
                    </div>
                    <input type="email" name="show-user-email" id="show-user-email" placeholder="Email: ">
                    <div class="label-detail-modal">
                        <label for="show-user-tel">Số điện thoại:</label>
                    </div>
                    <input type="tel" name="show-user-tel" id="show-user-tel" placeholder="Nhập số điện thoại">
                    <!-- <hr style="width:80%">
                    <div class="label-insert-modal">
                        <label for="new_users_password">Tạo mật khẩu</label>
                    </div>
                    <input type="password" name="show-user-password" id="show-user-password" placeholder="Nhập mật khẩu"> -->
                </div>
                <!-- end here -->

            </div>
        </div>
    </div>
</div>
</div>