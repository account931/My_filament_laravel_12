Emails are sent via mail facade in controller => Mail::to($data['email'])->queue(new CustomEmail($data['email'], $data['message'])); 
