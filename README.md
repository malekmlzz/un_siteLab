## un-sit

## Api for register laboratory and sonography
### POST:Send (full_name)(center_number)(phon_number)(role)(password)(password_confirmation)
[http://127.0.0.1:8000/api/v1/register/users]


## Api for register docter
### POST:Send (full_name)(national_code)(docter_code)(phon_number)(role)(password)(password_confirmation) 
[http://127.0.0.1:8000/api/v1/register/users]


## For laboratory and sonography login 
### POST : send (center_number) (password)
[http://127.0.0.1:8000/api/v1/login/users]

## For docter login
### POST : send (national_code) (password)
[http://127.0.0.1:8000/api/v1/login/users]

## For admin login
POST : send(email)(password)
[http://127.0.0.1:8000/api/v1/login/admin]

## For logOut
[http://127.0.0.1:8000/api/v1/logout]


## Api panel admin
### Add docter whit admin
#### POST: send (full_name)(national_code)(docter_code)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/docter/store]

### Add laboratory 
#### POST:send(full_name)(center_number)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/laboratory/store]

## Add sonography
#### POST:send(full_name)(center_number)(phone_number)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/sonography/store]

## Add admin 
#### POST : send(full_name)(email)(role)(password)
[http://127.0.0.1:8000/api/v1/admin/store]

## api delete users
### GET: send user_id
[http://127.0.0.1:8000/api/v1/admin/docter/delete/{user_id}]

## Api show all docter
#### GET : don’t need to any data
[http://127.0.0.1:8000/api/v1/admin/docter]

### Show all laboratory
[http://127.0.0.1:8000/api/v1/admin/laboratory]

### Api show all sonography
[http://127.0.0.1:8000/api/v1/admin/sonography]

### Api show all patient
[http://127.0.0.1:8000/api/v1/admin/patient]

### Show all admin
[http://127.0.0.1:8000/api/v1/admin]

### Api dashboard panel admin
[http://127.0.0.1:8000/api/v1/admin/dashborad]

## Api verify users
### GET:send user id
[http://127.0.0.1:8000/api/v1/admin/verifyUser/{user_id}]

### Api insert Experiment patient by laboratory and sonograph
#### POST : send(experiment_name)(national_code)(phon_number)(experiment_file)
[http://127.0.0.1:8000/api/v1/laboratory/dashborad/store]

## Api serach Experiment patient by Docter
POST : send(national_code)(start_data)(end_data)
[http://127.0.0.1:8000/api/v1/docter/dashborad/serach]

### Api change password into panel users by users (laboratory , sonograph , docter)
#### POST : send(old_password)(new_password)
[http://127.0.0.1:8000/api/v1/changePassword]

## api download experiment
### GET:send user id
[http://127.0.0.1:8000/api/v1/download/experiment/{user_id}]

## Api rest password 
 ### POST :for lab and sono send(center_number)
 ### POST : for docter send(national_code)
 [http://127.0.0.1:8000/api/v1/restPassword/sendCode]


 ## Receive code
 ### POST : send(code)(national_code)(password)
### POST : send(code)(center_unmber)(password)
[http://127.0.0.1:8000/api/v1/restPassword/vrifyCode]






