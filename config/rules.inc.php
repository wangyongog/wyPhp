<?php
return [
     'rules' =>[
         'view/<arid:\d+>.html' => 'view',
         'student/<arid:\d+>.html' => 'student/view',
         'teacher/<arid:\d+>.html' => 'teacher/view',
         'classtype/<typeid:\d+>.html' => 'classtype/index',
     ]
];