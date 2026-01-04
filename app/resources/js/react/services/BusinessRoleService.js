import api from "../common/api";

 const BusinessRoleService = {
  view: () => api.get("/business-access/view/business-role")
};
export default BusinessRoleService;