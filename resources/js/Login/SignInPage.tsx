"use client";

import React, { useState, useMemo, useRef, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { cn } from "@/lib/utils";
import { Canvas, useFrame, useThree } from "@react-three/fiber";

import * as THREE from "three";

type Uniforms = {
  [key: string]: {
    value: number[] | number[][] | number;
    type: string;
  };
};

interface ShaderProps {
  source: string;
  uniforms: {
    [key: string]: {
      value: number[] | number[][] | number;
      type: string;
    };
  };
  maxFps?: number;
}

interface SignInPageProps {
  className?: string;
}
      
export const CanvasRevealEffect = ({
  animationSpeed = 10,
  opacities = [0.3, 0.3, 0.3, 0.5, 0.5, 0.5, 0.8, 0.8, 0.8, 1],
  colors = [[0, 255, 255]],
  containerClassName,
  dotSize,
  showGradient = true,
  reverse = false,
}: {
  animationSpeed?: number;
  opacities?: number[];
  colors?: number[][];
  containerClassName?: string;
  dotSize?: number;
  showGradient?: boolean;
  reverse?: boolean;
}) => {
  return (
    <div className={cn("h-full relative w-full", containerClassName)}>
      <div className="h-full w-full">
        <DotMatrix
          colors={colors ?? [[0, 255, 255]]}
          dotSize={dotSize ?? 3}
          opacities={
            opacities ?? [0.3, 0.3, 0.3, 0.5, 0.5, 0.5, 0.8, 0.8, 0.8, 1]
          }
          shader={`
            ${reverse ? 'u_reverse_active' : 'false'}_;
            animation_speed_factor_${animationSpeed.toFixed(1)}_;
          `}
          center={["x", "y"]}
        />
      </div>
      {showGradient && (
         <div className="absolute inset-0 bg-gradient-to-t from-black to-transparent" />
      )}
    </div>
  );
};

interface DotMatrixProps {
  colors?: number[][];
  opacities?: number[];
  totalSize?: number;
  dotSize?: number;
  shader?: string;
  center?: ("x" | "y")[];
}

const DotMatrix: React.FC<DotMatrixProps> = ({
  colors = [[0, 0, 0]],
  opacities = [0.04, 0.04, 0.04, 0.04, 0.04, 0.08, 0.08, 0.08, 0.08, 0.14],
  totalSize = 20,
  dotSize = 2,
  shader = "",
  center = ["x", "y"],
}) => {
  const uniforms = React.useMemo(() => {
    let colorsArray = [
      colors[0],
      colors[0],
      colors[0],
      colors[0],
      colors[0],
      colors[0],
    ];
    if (colors.length === 2) {
      colorsArray = [
        colors[0],
        colors[0],
        colors[0],
        colors[1],
        colors[1],
        colors[1],
      ];
    } else if (colors.length === 3) {
      colorsArray = [
        colors[0],
        colors[0],
        colors[1],
        colors[1],
        colors[2],
        colors[2],
      ];
    }
    return {
      u_colors: {
        value: colorsArray.map((color) => [
          color[0] / 255,
          color[1] / 255,
          color[2] / 255,
        ]),
        type: "uniform3fv",
      },
      u_opacities: {
        value: opacities,
        type: "uniform1fv",
      },
      u_total_size: {
        value: totalSize,
        type: "uniform1f",
      },
      u_dot_size: {
        value: dotSize,
        type: "uniform1f",
      },
      u_reverse: {
        value: shader.includes("u_reverse_active") ? 1 : 0,
        type: "uniform1i",
      },
    };
  }, [colors, opacities, totalSize, dotSize, shader]);

  return (
    <Shader
      source={`
        precision mediump float;
        in vec2 fragCoord;

        uniform float u_time;
        uniform float u_opacities[10];
        uniform vec3 u_colors[6];
        uniform float u_total_size;
        uniform float u_dot_size;
        uniform vec2 u_resolution;
        uniform int u_reverse;

        out vec4 fragColor;

        float PHI = 1.61803398874989484820459;
        float random(vec2 xy) {
            return fract(tan(distance(xy * PHI, xy) * 0.5) * xy.x);
        }
        float map(float value, float min1, float max1, float min2, float max2) {
            return min2 + (value - min1) * (max2 - min2) / (max1 - min1);
        }

        void main() {
            vec2 st = fragCoord.xy;
            ${
              center.includes("x")
                ? "st.x -= abs(floor((mod(u_resolution.x, u_total_size) - u_dot_size) * 0.5));"
                : ""
            }
            ${
              center.includes("y")
                ? "st.y -= abs(floor((mod(u_resolution.y, u_total_size) - u_dot_size) * 0.5));"
                : ""
            }

            float opacity = step(0.0, st.x);
            opacity *= step(0.0, st.y);

            vec2 st2 = vec2(int(st.x / u_total_size), int(st.y / u_total_size));

            float frequency = 5.0;
            float show_offset = random(st2);
            float rand = random(st2 * floor((u_time / frequency) + show_offset + frequency));
            opacity *= u_opacities[int(rand * 10.0)];
            opacity *= 1.0 - step(u_dot_size / u_total_size, fract(st.x / u_total_size));
            opacity *= 1.0 - step(u_dot_size / u_total_size, fract(st.y / u_total_size));

            vec3 color = u_colors[int(show_offset * 6.0)];

            float animation_speed_factor = 0.5;
            vec2 center_grid = u_resolution / 2.0 / u_total_size;
            float dist_from_center = distance(center_grid, st2);

            float timing_offset_intro = dist_from_center * 0.01 + (random(st2) * 0.15);

            float max_grid_dist = distance(center_grid, vec2(0.0, 0.0));
            float timing_offset_outro = (max_grid_dist - dist_from_center) * 0.02 + (random(st2 + 42.0) * 0.2);

            float current_timing_offset;
            if (u_reverse == 1) {
                current_timing_offset = timing_offset_outro;
                 opacity *= 1.0 - step(current_timing_offset, u_time * animation_speed_factor);
                 opacity *= clamp((step(current_timing_offset + 0.1, u_time * animation_speed_factor)) * 1.25, 1.0, 1.25);
            } else {
                current_timing_offset = timing_offset_intro;
                 opacity *= step(current_timing_offset, u_time * animation_speed_factor);
                 opacity *= clamp((1.0 - step(current_timing_offset + 0.1, u_time * animation_speed_factor)) * 1.25, 1.0, 1.25);
            }

            fragColor = vec4(color, opacity);
            fragColor.rgb *= fragColor.a;
        }`}
      uniforms={uniforms}
      maxFps={60}
    />
  );
};

const ShaderMaterial = ({
  source,
  uniforms,
  maxFps = 60,
}: {
  source: string;
  hovered?: boolean;
  maxFps?: number;
  uniforms: Uniforms;
}) => {
  const { size } = useThree();
  const ref = useRef<THREE.Mesh>(null);
  let lastFrameTime = 0;

  useFrame(({ clock }) => {
    if (!ref.current) return;
    const timestamp = clock.getElapsedTime();

    lastFrameTime = timestamp;

    const material: any = ref.current.material;
    const timeLocation = material.uniforms.u_time;
    timeLocation.value = timestamp;
  });

  const getUniforms = () => {
    const preparedUniforms: any = {};

    for (const uniformName in uniforms) {
      const uniform: any = uniforms[uniformName];

      switch (uniform.type) {
        case "uniform1f":
          preparedUniforms[uniformName] = { value: uniform.value, type: "1f" };
          break;
        case "uniform1i":
          preparedUniforms[uniformName] = { value: uniform.value, type: "1i" };
          break;
        case "uniform3f":
          preparedUniforms[uniformName] = {
            value: new THREE.Vector3().fromArray(uniform.value),
            type: "3f",
          };
          break;
        case "uniform1fv":
          preparedUniforms[uniformName] = { value: uniform.value, type: "1fv" };
          break;
        case "uniform3fv":
          preparedUniforms[uniformName] = {
            value: uniform.value.map((v: number[]) =>
              new THREE.Vector3().fromArray(v)
            ),
            type: "3fv",
          };
          break;
        case "uniform2f":
          preparedUniforms[uniformName] = {
            value: new THREE.Vector2().fromArray(uniform.value),
            type: "2f",
          };
          break;
        default:
          console.error(`Invalid uniform type for '${uniformName}'.`);
          break;
      }
    }

    preparedUniforms["u_time"] = { value: 0, type: "1f" };
    preparedUniforms["u_resolution"] = {
      value: new THREE.Vector2(size.width * 2, size.height * 2),
    };
    return preparedUniforms;
  };

  const material = useMemo(() => {
    const materialObject = new THREE.ShaderMaterial({
      vertexShader: `
      precision mediump float;
      in vec2 coordinates;
      uniform vec2 u_resolution;
      out vec2 fragCoord;
      void main(){
        float x = position.x;
        float y = position.y;
        gl_Position = vec4(x, y, 0.0, 1.0);
        fragCoord = (position.xy + vec2(1.0)) * 0.5 * u_resolution;
        fragCoord.y = u_resolution.y - fragCoord.y;
      }
      `,
      fragmentShader: source,
      uniforms: getUniforms(),
      glslVersion: THREE.GLSL3,
      blending: THREE.CustomBlending,
      blendSrc: THREE.SrcAlphaFactor,
      blendDst: THREE.OneFactor,
    });

    return materialObject;
  }, [size.width, size.height, source]);

  return (
    <mesh ref={ref as any}>
      <planeGeometry args={[2, 2]} />
      <primitive object={material} attach="material" />
    </mesh>
  );
};

const Shader: React.FC<ShaderProps> = ({ source, uniforms, maxFps = 60 }) => {
  return (
    <Canvas className="absolute inset-0 h-full w-full">
      <ShaderMaterial source={source} uniforms={uniforms} maxFps={maxFps} />
    </Canvas>
  );
};

export const SignInPage = ({ className }: SignInPageProps) => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [step, setStep] = useState<"login" | "success">("login");
  const [initialCanvasVisible, setInitialCanvasVisible] = useState(true);
  const [reverseCanvasVisible, setReverseCanvasVisible] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (email && password) {
      // Show reverse animation and hide initial canvas
      setReverseCanvasVisible(true);
      setTimeout(() => {
        setInitialCanvasVisible(false);
      }, 50);
      
      // Transition to success state
      setTimeout(() => {
        setStep("success");
      }, 2000);
    }
  };

  return (
    <div className={cn("flex w-full flex-col min-h-screen bg-black relative overflow-hidden", className)}>
      <div className="absolute inset-0 z-0">
        {/* Initial canvas (forward animation) */}
        {initialCanvasVisible && (
          <div className="absolute inset-0">
            <CanvasRevealEffect
              animationSpeed={3}
              containerClassName="bg-black"
              colors={[
                [255, 255, 255],
                [255, 255, 255],
              ]}
              dotSize={6}
              reverse={false}
            />
          </div>
        )}
        
        {/* Reverse canvas (appears when login successful) */}
        {reverseCanvasVisible && (
          <div className="absolute inset-0">
            <CanvasRevealEffect
              animationSpeed={4}
              containerClassName="bg-black"
              colors={[
                [255, 255, 255],
                [255, 255, 255],
              ]}
              dotSize={6}
              reverse={true}
            />
          </div>
        )}
        
        <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(0,0,0,1)_0%,_transparent_100%)] pointer-events-none" />
        <div className="absolute top-0 left-0 right-0 h-1/3 bg-gradient-to-b from-black to-transparent pointer-events-none" />
      </div>
      
      {/* Content Layer */}
      <div className="relative z-10 flex flex-col flex-1">
        {/* Main content container */}
        <div className="flex flex-1 flex-col justify-center items-center px-4">
          <div className="w-full max-w-sm">
            <AnimatePresence mode="wait">
              {step === "login" ? (
                <motion.div 
                  key="login-step"
                  initial={{ opacity: 0, x: -50 }}
                  animate={{ opacity: 1, x: 0 }}
                  exit={{ opacity: 0, x: 50 }}
                  transition={{ duration: 0.4, ease: "easeOut" }}
                  className="space-y-8"
                >
                  <div className="text-center space-y-2">
                    <h1 className="text-4xl font-bold tracking-tight text-white">Welcome Back</h1>
                    <p className="text-lg text-white/60 font-light">Sign in to your account</p>
                  </div>
                  
                  <div className="space-y-6">
                    <button type="button" className="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-full py-3 px-4 transition-colors backdrop-blur-sm group">
                      <svg className="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                      </svg>
                      <span className="font-medium">Continue with Google</span>
                    </button>
                    
                    <div className="flex items-center gap-4">
                      <div className="h-px bg-white/10 flex-1" />
                      <span className="text-white/40 text-xs font-medium uppercase tracking-wider">Or continue with</span>
                      <div className="h-px bg-white/10 flex-1" />
                    </div>
                    
                    <form onSubmit={handleSubmit} className="space-y-4">
                      <div>
                        <input 
                          type="email" 
                          placeholder="Email address"
                          value={email}
                          onChange={(e) => setEmail(e.target.value)}
                          className="w-full bg-white/5 border border-white/10 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-white/30 focus:bg-white/10 transition-all placeholder:text-white/30 backdrop-blur-sm"
                          required
                        />
                      </div>
                      <div>
                        <input 
                          type="password" 
                          placeholder="Password"
                          value={password}
                          onChange={(e) => setPassword(e.target.value)}
                          className="w-full bg-white/5 border border-white/10 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-white/30 focus:bg-white/10 transition-all placeholder:text-white/30 backdrop-blur-sm"
                          required
                        />
                      </div>
                      <button 
                        type="submit"
                        className="w-full bg-white text-black font-semibold rounded-xl py-3 px-4 hover:bg-white/90 active:scale-[0.98] transition-all mt-2"
                      >
                        Sign In
                      </button>
                    </form>
                  </div>
                  
                  <div className="flex justify-between items-center text-sm pt-4">
                    <a href="#" className="text-white/50 hover:text-white transition-colors">Forgot password?</a>
                    <a href="#" className="text-white/50 hover:text-white transition-colors">Create account</a>
                  </div>
                </motion.div>
              ) : (
                <motion.div 
                  key="success-step"
                  initial={{ opacity: 0, scale: 0.95 }}
                  animate={{ opacity: 1, scale: 1 }}
                  transition={{ duration: 0.5, ease: "easeOut", delay: 0.2 }}
                  className="space-y-8 text-center bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8"
                >
                  <motion.div 
                    initial={{ scale: 0, opacity: 0 }}
                    animate={{ scale: 1, opacity: 1 }}
                    transition={{ type: "spring", stiffness: 200, damping: 20, delay: 0.5 }}
                    className="mx-auto w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-[0_0_40px_rgba(255,255,255,0.3)]"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-10 w-10 text-black" viewBox="0 0 20 20" fill="currentColor">
                      <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                    </svg>
                  </motion.div>
                  
                  <div className="space-y-2">
                    <h1 className="text-3xl font-bold tracking-tight text-white">Authentication Successful</h1>
                    <p className="text-white/60">Redirecting to your dashboard...</p>
                  </div>
                </motion.div>
              )}
            </AnimatePresence>
          </div>
        </div>
      </div>
    </div>
  );
};
