function Notify({ type, message, handleNotificationClose }) {
    const classes = {
        success: "bg-green-500",
        error: "bg-red-500",
    };

    return (
        <div className={`fixed mt-5 top-4 right-4 p-4 text-white ${classes[type]} z-50`}>
            <p>{message}</p>
            <button className="ml-2" onClick={handleNotificationClose}>
                X
            </button>
        </div>
    );
}

export default Notify;
