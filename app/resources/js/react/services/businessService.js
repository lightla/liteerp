import api from "../common/api";

 const businessService = {
  add: (data) => api.post("/business",data),
  list: () => api.get("/business"),
  show: (id) => api.get("/business/" + id)
};
export default businessService;