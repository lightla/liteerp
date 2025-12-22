import api from "../common/api";

 const NotificationService = {
  list: ({
    page = 0,
    type = ''
  }) => api.get("/business-access/notifications" 
    + `?page=${page}&type=${type}`),
  listIsNotRead: () => api.get("/business-access/notifications" 
    + `?is_not_read=1`),
  listType: () => api.get("/business-access/notifications" 
    + `?get_type=1`),
  update: (data) => api.put("/business-access/notifications/" + data.id,data),
  delete: (data) => api.delete("/business-access/notifications/" + data.id,data)
};
export default NotificationService;