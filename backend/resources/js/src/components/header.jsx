import React from 'react';
import { AppBar, Toolbar, Button, Typography, Box, IconButton } from '@mui/material';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';

const Header = () => {
    const [isLogin, setIsLogin] = React.useState(false);

    const handleLogin = () => {
        setIsLogin(true);
    };

    const handleLogout = () => {
        setIsLogin(false);
    };

  return (
    <Box>
      <Box sx={{ backgroundColor: 'black', color: 'white', textAlign: 'center', py: 1 }}>
        Sign up and get 20% off to your first order. <strong>Sign Up Now</strong>
      </Box>
      <AppBar position="static" color="transparent" elevation={0}>
        <Toolbar sx={{ justifyContent: 'space-between' }}>
          <Typography variant="h6">izam</Typography>
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
            <Button color="inherit">Products</Button>
            <Button variant="outlined">Sell Your Product</Button>
            <IconButton>
              <ShoppingCartIcon />
            </IconButton>
            {isLogin ? (
                <Button variant="contained" onClick={handleLogout}>Logout</Button>
            ) : (
                <Button variant="contained" onClick={handleLogin}>Login</Button>
            )}
          </Box>
        </Toolbar>
      </AppBar>
    </Box>
  );
};

export default Header;
