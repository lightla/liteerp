import api from "../common/api";

 const UserService = {
  add: (data) => api.post("/business-access/users",data),
  update: (data) => api.put("/business-access/users/" + data.id,data),
  show: (id) => api.get("/business-access/users/" + id),
  list: ({
    keywords = '',
    page = ''
  }) => api.get("/business-access/users" 
    + `?keywords=${keywords}&page=${page}`)
};
export default UserService;