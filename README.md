# secapp
Annotation based framework, to add security to the zend application mvc framework. See http://aktey.de/secapp/public/ to see the demo application in action.

This framework adds role based security support to your Zend application. Therefor controller classes or action methods could be "annotated" with an "@roles(role1, role2)" annotation, which means in an PHP context to put an @role in the doc block of your class or method.
If the body of the @roles annotation kept empty, means that the user has to be logged in without having a certain role.
In the example there are two roles: admin, user. There are also two registered users: userotto, who has only the user role and adminotto, who has both, the admin and the user role. There is no password to log in to the demo sites, just keep it blank.

This framework also adds a resource injection mechanism to your Zend application.

