import api from "../common/api";

 const ActivityLogService = {
  list: (data) => api.get("/business-access/activity-logs?page=" + data.page)
};
export default ActivityLogService;