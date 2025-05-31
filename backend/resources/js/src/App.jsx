import { Container } from "@mui/material";
import { Suspense } from "react";
import { Outlet } from "react-router-dom";
import Header from "./components/header";

export default function App() {
    return (
      <>
        <Header />
        <Container maxWidth="lg" sx={{ mt: 4 }}>
          <Suspense fallback={<div>Loading...</div>}>
            <Outlet />
          </Suspense>
        </Container>
      </>
    );
}