UPGRADE notes

sketch-12 changes vs sketch-11:
- Added base screen context provider + screen context resolvers + assembler.
- InterfaceController now passes assembled context into Live screens.
- Added explicit screen/action/shell authorization resolvers and improved authorization context passing.
- InterfaceDoctorService now reports context resolver count and the active authorization resolver class.
