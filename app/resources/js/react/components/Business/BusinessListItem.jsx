import React from "react";
import SuccessButton from "../UI/Buttons/SuccessButton";
import FlatIcon32 from "../UI/FlatIcons/FlatIcon32";

export default function BusinessListItem({
  business = null,
  onViewDetail = () => { },
  buttonBottomText = 'Dashboard'
}) {
  return (
    <div className="theme-card border rounded-4">
      <div className="row p-3">
        {/* Left Section */}
        <div className="membership-left col-8">
          <div className="membership-icon">
            <FlatIcon32 size={64} name={"prenium64x64"} />
          </div>
          <div className="membership-info">
            <h5 className="theme-title-highlight">{business?.name} </h5>
            <p className="theme-title">{business?.address}</p>
          </div>
        </div>

        {/* Right Section */}
        <div className="membership-right col-4">
          <SuccessButton width={200} label={buttonBottomText} onClick={onViewDetail} />
        </div>
      </div>
    </div>
  );
}
